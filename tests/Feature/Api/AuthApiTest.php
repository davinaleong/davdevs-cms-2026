<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
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
        ->assertJsonPath('data.user.email', 'john@example.com');
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
        ->assertJsonPath('data.email_verified', true);
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
