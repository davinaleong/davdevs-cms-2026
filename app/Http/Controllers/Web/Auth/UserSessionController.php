<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSessionController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.user.login');
    }

    public function registerForm(): View
    {
        return view('auth.user.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->only(['email', 'password']))) {
            return back()
                ->withErrors(['email' => 'The provided credentials are invalid.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());
        $user->sendEmailVerificationNotification();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
