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
use App\Http\Controllers\JokesPageController;
use App\Http\Controllers\PostPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts/{post:slug}', [PostPageController::class, 'show'])->name('posts.show');
Route::get('/jokes', JokesPageController::class)->name('jokes.index');

Route::prefix('auth')->group(function (): void {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth');
    Route::get('/me', MeController::class)->middleware('auth');
    Route::post('/email/verification-notification', SendEmailVerificationController::class)
        ->middleware(['auth', 'throttle:6,1']);
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('api.verification.verify');
    Route::post('/2fa/setup', TwoFactorSetupController::class)->middleware('auth');
    Route::post('/2fa/verify', TwoFactorVerifyController::class)->middleware('auth');
    Route::post('/2fa/recovery-codes/regenerate', TwoFactorRecoveryCodesRegenerateController::class)->middleware('auth');
    Route::post('/2fa/recovery-codes/download', TwoFactorRecoveryCodesDownloadController::class)->middleware('auth');
});

Route::prefix('admin/auth')->group(function (): void {
    Route::post('/login', AdminLoginController::class);
    Route::middleware('auth:admin')->group(function (): void {
        Route::get('/me', AdminMeController::class);
        Route::post('/force-password-change', AdminForcePasswordChangeController::class);
        Route::post('/2fa/setup', AdminTwoFactorSetupController::class);
        Route::post('/2fa/verify', AdminTwoFactorVerifyController::class);
        Route::post('/2fa/recovery-codes/regenerate', AdminTwoFactorRecoveryCodesRegenerateController::class);
        Route::post('/2fa/recovery-codes/download', AdminTwoFactorRecoveryCodesDownloadController::class);
    });
});
