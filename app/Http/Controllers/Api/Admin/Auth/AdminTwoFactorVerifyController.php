<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactorVerifyRequest;
use App\Models\Admin;
use App\Support\Security\TotpService;
use App\Support\Security\TwoFactorRecoveryCodeService;
use Illuminate\Http\JsonResponse;

class AdminTwoFactorVerifyController extends Controller
{
    public function __invoke(
        TwoFactorVerifyRequest $request,
        TotpService $totpService,
        TwoFactorRecoveryCodeService $recoveryCodeService,
    ): JsonResponse {
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

        $totpCode = $request->string('code')->toString();

        if ($totpCode !== '' && $totpService->verifyCode($secret, $totpCode)) {
            $request->user()->forceFill([
                'two_factor_confirmed_at' => now(),
            ])->save();

            return response()->json([
                'data' => [
                    'two_factor_enabled' => true,
                    'used_recovery_code' => false,
                ],
            ]);
        }

        $recoveryCodes = $request->user()->two_factor_recovery_codes;
        $consumptionResult = $recoveryCodeService->consumeCode(
            is_array($recoveryCodes) ? $recoveryCodes : [],
            (string) $request->input('recovery_code', ''),
        );

        if (! $consumptionResult['consumed']) {
            return response()->json([
                'message' => 'The provided authentication code is invalid.',
                'errors' => [
                    'code' => ['The provided authentication code is invalid.'],
                    'recovery_code' => ['The provided recovery code is invalid.'],
                ],
            ], 422);
        }

        $request->user()->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => $consumptionResult['remaining_codes'],
        ])->save();

        return response()->json([
            'data' => [
                'two_factor_enabled' => true,
                'used_recovery_code' => true,
                'recovery_codes_remaining' => count($consumptionResult['remaining_codes']),
            ],
        ]);
    }
}
