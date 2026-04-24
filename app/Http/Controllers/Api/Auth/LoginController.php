<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are invalid.',
                'errors' => [
                    'email' => ['The provided credentials are invalid.'],
                ],
            ], 422);
        }

        $request->session()->regenerate();

        $user = $request->user();

        return response()->json([
            'data' => [
                'user' => $user,
                'two_factor_enabled' => $user->hasTwoFactorEnabled(),
            ],
        ]);
    }
}
