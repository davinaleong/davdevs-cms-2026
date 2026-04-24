<?php

use App\Models\Admin;
use App\Models\User;
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
        ->assertJsonPath('data.must_change_password', true);
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
        ->assertJsonPath('data.must_change_password', true);
});

it('rejects user token on admin me endpoint', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = getJson('/api/admin/auth/me');

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
