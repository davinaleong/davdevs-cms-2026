<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());
        $user->sendEmailVerificationNotification();

        return response()->json([
            'data' => [
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user,
                'email_verification_sent' => true,
            ],
        ], 201);
    }
}
