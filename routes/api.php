<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/post-types', PostTypeController::class);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::apiResource('posts', PostController::class)->except(['show']);
