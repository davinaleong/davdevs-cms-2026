<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(20),
        ]);
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
            'likedPosts' => $user->likes()->with('post')->latest()->limit(10)->get(),
        ]);
    }

    public function togglePremium(User $user, Request $request): RedirectResponse
    {
        $user->update([
            'is_premium' => ! $user->is_premium,
        ]);

        return back()->with('status', 'Premium status updated.');
    }
}
