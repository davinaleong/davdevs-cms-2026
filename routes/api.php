<?php

use App\Http\Controllers\Api\Admin\Auth\AdminForcePasswordChangeController;
use App\Http\Controllers\Api\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Api\Admin\Auth\AdminMeController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorRecoveryCodesDownloadController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorRecoveryCodesRegenerateController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorSetupController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorVerifyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SendEmailVerificationController;
use App\Http\Controllers\Api\Auth\TwoFactorRecoveryCodesDownloadController;
use App\Http\Controllers\Api\Auth\TwoFactorRecoveryCodesRegenerateController;
use App\Http\Controllers\Api\Auth\TwoFactorSetupController;
use App\Http\Controllers\Api\Auth\TwoFactorVerifyController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostLikeToggleController;
use App\Http\Controllers\Api\PostTypeController;
use App\Http\Controllers\Api\RandomJokeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
    Route::get('/me', MeController::class)->middleware('auth:sanctum');
    Route::post('/email/verification-notification', SendEmailVerificationController::class)
        ->middleware(['auth:sanctum', 'throttle:6,1']);
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
        ->name('api.verification.verify');
    Route::post('/2fa/setup', TwoFactorSetupController::class)->middleware('auth:sanctum');
    Route::post('/2fa/verify', TwoFactorVerifyController::class)->middleware('auth:sanctum');
    Route::post('/2fa/recovery-codes/regenerate', TwoFactorRecoveryCodesRegenerateController::class)->middleware('auth:sanctum');
    Route::post('/2fa/recovery-codes/download', TwoFactorRecoveryCodesDownloadController::class)->middleware('auth:sanctum');
});

Route::prefix('admin/auth')->group(function (): void {
    Route::post('/login', AdminLoginController::class);
    Route::middleware(['auth:sanctum', 'admin'])->group(function (): void {
        Route::get('/me', AdminMeController::class);
        Route::post('/force-password-change', AdminForcePasswordChangeController::class);
        Route::post('/2fa/setup', AdminTwoFactorSetupController::class);
        Route::post('/2fa/verify', AdminTwoFactorVerifyController::class);
        Route::post('/2fa/recovery-codes/regenerate', AdminTwoFactorRecoveryCodesRegenerateController::class);
        Route::post('/2fa/recovery-codes/download', AdminTwoFactorRecoveryCodesDownloadController::class);
    });
});

Route::get('/post-types', PostTypeController::class);
Route::get('/jokes/random', RandomJokeController::class);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function (): void {
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post:slug}', [PostController::class, 'update']);
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy']);
});
Route::post('/posts/{post:slug}/likes/toggle', PostLikeToggleController::class)->middleware('auth:sanctum');
