<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Support\Security\TotpService;
use App\Support\Security\TwoFactorRecoveryCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTwoFactorSetupController extends Controller
{
    public function __invoke(
        Request $request,
        TotpService $totpService,
        TwoFactorRecoveryCodeService $recoveryCodeService,
    ): JsonResponse {
        if (! $request->user() instanceof Admin) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $secret = $totpService->generateSecret();
        $recoveryCodes = $recoveryCodeService->generatePlainCodes();

        $request->user()->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => $recoveryCodeService->hashCodes($recoveryCodes),
            'two_factor_confirmed_at' => null,
        ])->save();

        return response()->json([
            'data' => [
                'secret' => $secret,
                'otpauth_url' => $totpService->provisioningUri(
                    label: $request->user()->email,
                    issuer: config('app.name'),
                    secret: $secret,
                ),
                'recovery_codes' => $recoveryCodes,
                'recovery_codes_text' => $recoveryCodeService->asText($recoveryCodes),
                'two_factor_enabled' => false,
            ],
        ]);
    }
}
