<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SendEmailVerificationController;
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
});

Route::get('/post-types', PostTypeController::class);
Route::get('/jokes/random', RandomJokeController::class);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::apiResource('posts', PostController::class)->except(['show']);
Route::post('/posts/{post:slug}/likes/toggle', PostLikeToggleController::class)->middleware('auth:sanctum');
