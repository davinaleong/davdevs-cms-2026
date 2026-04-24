<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminForcePasswordChangeRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSessionController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.admin.login');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        if (! Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
            return back()
                ->withErrors(['email' => 'The provided admin credentials are invalid.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }

    public function forcePasswordForm(Request $request): View
    {
        return view('auth.admin.force-password', [
            'admin' => $request->user('admin'),
        ]);
    }

    public function forcePasswordUpdate(AdminForcePasswordChangeRequest $request): RedirectResponse
    {
        $admin = $request->user('admin');

        if (! $admin instanceof Admin) {
            abort(403);
        }

        if (! Hash::check($request->string('current_password')->toString(), $admin->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $admin->update([
            'password' => $request->string('password')->toString(),
            'must_change_password' => false,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Password updated.');
    }
}
