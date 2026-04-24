<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());
        $user->sendEmailVerificationNotification();

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'data' => [
                'user' => $user,
                'email_verification_sent' => true,
            ],
        ], 201);
    }
}
