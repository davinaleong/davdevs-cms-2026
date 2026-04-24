<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'data' => [
                    'verified' => true,
                    'message' => 'Email already verified.',
                ],
            ]);
        }

        $request->fulfill();

        return response()->json([
            'data' => [
                'verified' => true,
                'message' => 'Email verified successfully.',
            ],
        ]);
    }
}
