<?php

use App\Models\Admin;
use App\Models\User;
use App\Support\Security\TotpService;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('logs in an admin and returns force-password-change status', function () {
    Admin::factory()->create([
        'email' => 'admin@example.com',
        'password' => 'password123',
        'must_change_password' => true,
    ]);

    $response = postJson('/api/admin/auth/login', [
        'email' => 'admin@example.com',
        'password' => 'password123',
    ]);

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.admin.email', 'admin@example.com')
        ->assertJsonPath('data.must_change_password', true)
        ->assertJsonPath('data.two_factor_enabled', false);
});

it('returns admin profile for authenticated admin', function () {
    $admin = Admin::factory()->create([
        'must_change_password' => true,
    ]);

    Sanctum::actingAs($admin);

    $response = getJson('/api/admin/auth/me');

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.admin.id', $admin->id)
        ->assertJsonPath('data.must_change_password', true)
        ->assertJsonPath('data.two_factor_enabled', false);
});

it('rejects user token on admin me endpoint', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = getJson('/api/admin/auth/me');

    $response->assertForbidden();
});

it('rejects user token on admin force password change endpoint', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = postJson('/api/admin/auth/force-password-change', [
        'current_password' => 'password123',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertForbidden();
});

it('forces admin password change and clears flag', function () {
    $admin = Admin::factory()->create([
        'password' => 'password123',
        'must_change_password' => true,
    ]);

    Sanctum::actingAs($admin);

    $response = postJson('/api/admin/auth/force-password-change', [
        'current_password' => 'password123',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.must_change_password', false);

    expect($admin->fresh()->must_change_password)->toBeFalse();

    $loginResponse = postJson('/api/admin/auth/login', [
        'email' => $admin->email,
        'password' => 'newpassword123',
    ]);

    $loginResponse->assertSuccessful()->assertJsonPath('data.must_change_password', false);
});

it('sets up two factor authentication for admins', function () {
    $admin = Admin::factory()->create();
    Sanctum::actingAs($admin);

    $response = postJson('/api/admin/auth/2fa/setup');

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.two_factor_enabled', false)
        ->assertJsonCount(8, 'data.recovery_codes');

    $secret = $response->json('data.secret');
    $recoveryCode = $response->json('data.recovery_codes.0');

    expect($secret)->not->toBeEmpty();
    expect($response->json('data.otpauth_url'))->toContain('otpauth://totp/');

    $refreshedAdmin = $admin->fresh();

    expect($refreshedAdmin->two_factor_confirmed_at)->toBeNull();
    expect($refreshedAdmin->getRawOriginal('two_factor_secret'))->not->toBe($secret);
    expect($refreshedAdmin->two_factor_recovery_codes)->toHaveCount(8);
    expect(Hash::check($recoveryCode, $refreshedAdmin->two_factor_recovery_codes[0]))->toBeTrue();
});

it('verifies admin two factor authentication code', function () {
    $admin = Admin::factory()->create();
    Sanctum::actingAs($admin);

    $setupResponse = postJson('/api/admin/auth/2fa/setup');
    $secret = $setupResponse->json('data.secret');

    $code = app(TotpService::class)->currentCode($secret);

    $verifyResponse = postJson('/api/admin/auth/2fa/verify', [
        'code' => $code,
    ]);

    $verifyResponse
        ->assertSuccessful()
        ->assertJsonPath('data.two_factor_enabled', true);

    expect($admin->fresh()->two_factor_confirmed_at)->not->toBeNull();
});
