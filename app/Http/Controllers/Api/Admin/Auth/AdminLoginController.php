<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __invoke(AdminLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'message' => 'The provided admin credentials are invalid.',
                'errors' => [
                    'email' => ['The provided admin credentials are invalid.'],
                ],
            ], 422);
        }

        $request->session()->regenerate();

        $admin = Auth::guard('admin')->user();

        return response()->json([
            'data' => [
                'admin' => $admin,
                'must_change_password' => $admin->must_change_password,
                'two_factor_enabled' => $admin->hasTwoFactorEnabled(),
            ],
        ]);
    }
}
