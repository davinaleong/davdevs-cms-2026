<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostLikeToggleController;
use App\Http\Controllers\Api\PostTypeController;
use App\Http\Controllers\Api\RandomJokeController;
use Illuminate\Support\Facades\Route;

Route::get('/post-types', PostTypeController::class);
Route::get('/jokes/random', RandomJokeController::class);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::apiResource('posts', PostController::class)->except(['show']);
Route::post('/posts/{post:slug}/likes/toggle', PostLikeToggleController::class)->middleware('auth:sanctum');
