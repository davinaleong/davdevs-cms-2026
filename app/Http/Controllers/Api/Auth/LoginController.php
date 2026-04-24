<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->string('email')->toString())->first();

        if (! $user || ! Hash::check($request->string('password')->toString(), $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are invalid.',
                'errors' => [
                    'email' => ['The provided credentials are invalid.'],
                ],
            ], 422);
        }

        return response()->json([
            'data' => [
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user,
            ],
        ]);
    }
}
