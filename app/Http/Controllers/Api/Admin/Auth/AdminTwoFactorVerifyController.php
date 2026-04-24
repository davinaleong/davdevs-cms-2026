<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactorVerifyRequest;
use App\Models\Admin;
use App\Support\Security\TotpService;
use Illuminate\Http\JsonResponse;

class AdminTwoFactorVerifyController extends Controller
{
    public function __invoke(TwoFactorVerifyRequest $request, TotpService $totpService): JsonResponse
    {
        if (! $request->user() instanceof Admin) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $secret = $request->user()->two_factor_secret;

        if (! is_string($secret) || $secret === '') {
            return response()->json([
                'message' => 'Two-factor authentication has not been set up.',
                'errors' => [
                    'code' => ['Two-factor authentication has not been set up.'],
                ],
            ], 422);
        }

        if (! $totpService->verifyCode($secret, $request->string('code')->toString())) {
            return response()->json([
                'message' => 'The provided authentication code is invalid.',
                'errors' => [
                    'code' => ['The provided authentication code is invalid.'],
                ],
            ], 422);
        }

        $request->user()->forceFill([
            'two_factor_confirmed_at' => now(),
        ])->save();

        return response()->json([
            'data' => [
                'two_factor_enabled' => true,
            ],
        ]);
    }
}
