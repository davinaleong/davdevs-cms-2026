<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendEmailVerificationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'data' => [
                    'email_verification_sent' => false,
                    'message' => 'Email already verified.',
                ],
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'data' => [
                'email_verification_sent' => true,
                'message' => 'Verification link sent.',
            ],
        ]);
    }
}
