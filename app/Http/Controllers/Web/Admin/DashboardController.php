<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joke;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalPosts' => Post::query()->count(),
            'draftPosts' => Post::query()->where('status', 'draft')->count(),
            'totalUsers' => User::query()->count(),
            'recentPosts' => Post::query()->latest()->limit(5)->get(),
            'recentJokes' => Joke::query()->latest()->limit(5)->get(),
        ]);
    }
}
