<?php

use App\Http\Controllers\JokesPageController;
use App\Http\Controllers\PostPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts/{post:slug}', [PostPageController::class, 'show'])->name('posts.show');
Route::get('/jokes', JokesPageController::class)->name('jokes.index');
