<?php

use App\Models\Admin;
use App\Models\User;
use App\Support\Security\TotpService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('registers a user and returns a token', function () {
    Notification::fake();

    $response = postJson('/api/auth/register', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('data.user.email', 'jane@example.com');

    $user = User::query()->where('email', 'jane@example.com')->first();
    expect($user)->not->toBeNull();
    Notification::assertSentTo($user, VerifyEmail::class);
});

it('logs in a user with valid credentials', function () {
    User::factory()->create([
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response = postJson('/api/auth/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.user.email', 'john@example.com')
        ->assertJsonPath('data.two_factor_enabled', false);
});

it('rejects invalid login credentials', function () {
    User::factory()->create([
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response = postJson('/api/auth/login', [
        'email' => 'john@example.com',
        'password' => 'invalid-password',
    ]);

    $response->assertStatus(422);
});

it('returns the authenticated user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = getJson('/api/auth/me');

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.user.id', $user->id)
        ->assertJsonPath('data.email_verified', true)
        ->assertJsonPath('data.two_factor_enabled', false);
});

it('logs out and revokes the current token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api-token')->plainTextToken;

    $response = postJson('/api/auth/logout', [], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertNoContent();
    expect($user->fresh()->tokens()->count())->toBe(0);
});

it('sends a verification email for authenticated unverified users', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();
    Sanctum::actingAs($user);

    $response = postJson('/api/auth/email/verification-notification');

    $response->assertSuccessful()->assertJsonPath('data.email_verification_sent', true);
    Notification::assertSentTo($user, VerifyEmail::class);
});

it('verifies email using signed url', function () {
    $user = User::factory()->unverified()->create();
    Sanctum::actingAs($user);

    $signedUrl = URL::temporarySignedRoute('api.verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1($user->getEmailForVerification()),
    ]);

    $response = getJson($signedUrl);

    $response->assertSuccessful()->assertJsonPath('data.verified', true);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('sets up two factor authentication for users', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = postJson('/api/auth/2fa/setup');

    $response
        ->assertSuccessful()
        ->assertJsonPath('data.two_factor_enabled', false)
        ->assertJsonCount(8, 'data.recovery_codes');

    $secret = $response->json('data.secret');
    $recoveryCode = $response->json('data.recovery_codes.0');

    expect($secret)->not->toBeEmpty();
    expect($response->json('data.otpauth_url'))->toContain('otpauth://totp/');
    expect($response->json('data.recovery_codes_text'))->toContain(PHP_EOL);

    $refreshedUser = $user->fresh();

    expect($refreshedUser->two_factor_confirmed_at)->toBeNull();
    expect($refreshedUser->getRawOriginal('two_factor_secret'))->not->toBe($secret);
    expect($refreshedUser->two_factor_recovery_codes)->toHaveCount(8);
    expect(Hash::check($recoveryCode, $refreshedUser->two_factor_recovery_codes[0]))->toBeTrue();
});

it('verifies user two factor authentication code', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $setupResponse = postJson('/api/auth/2fa/setup');
    $secret = $setupResponse->json('data.secret');

    $code = app(TotpService::class)->currentCode($secret);

    $verifyResponse = postJson('/api/auth/2fa/verify', [
        'code' => $code,
    ]);

    $verifyResponse
        ->assertSuccessful()
        ->assertJsonPath('data.two_factor_enabled', true);

    expect($user->fresh()->two_factor_confirmed_at)->not->toBeNull();
});

it('verifies user two factor with a recovery code and consumes it', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $setupResponse = postJson('/api/auth/2fa/setup');
    $recoveryCode = $setupResponse->json('data.recovery_codes.0');

    $verifyResponse = postJson('/api/auth/2fa/verify', [
        'recovery_code' => $recoveryCode,
    ]);

    $verifyResponse
        ->assertSuccessful()
        ->assertJsonPath('data.two_factor_enabled', true)
        ->assertJsonPath('data.used_recovery_code', true)
        ->assertJsonPath('data.recovery_codes_remaining', 7);

    $reuseResponse = postJson('/api/auth/2fa/verify', [
        'recovery_code' => $recoveryCode,
    ]);

    $reuseResponse->assertUnprocessable();
});

it('regenerates user recovery codes', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    postJson('/api/auth/2fa/setup')->assertSuccessful();

    $response = postJson('/api/auth/2fa/recovery-codes/regenerate');

    $response
        ->assertSuccessful()
        ->assertJsonCount(8, 'data.recovery_codes');

    expect($response->json('data.recovery_codes_text'))->toContain(PHP_EOL);
    expect($user->fresh()->two_factor_recovery_codes)->toHaveCount(8);
});

it('downloads user recovery codes as txt', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    postJson('/api/auth/2fa/setup')->assertSuccessful();

    $response = post('/api/auth/2fa/recovery-codes/download');

    $response
        ->assertSuccessful()
        ->assertHeader('content-type', 'text/plain; charset=UTF-8')
        ->assertHeader('content-disposition', 'attachment; filename=user-recovery-codes.txt');
});

it('rejects admin token on user two factor endpoints', function () {
    Sanctum::actingAs(Admin::factory()->create());

    $setupResponse = postJson('/api/auth/2fa/setup');
    $verifyResponse = postJson('/api/auth/2fa/verify', [
        'code' => '123456',
    ]);

    $setupResponse->assertForbidden();
    $verifyResponse->assertForbidden();
});
