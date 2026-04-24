<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Security\TwoFactorRecoveryCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwoFactorRecoveryCodesRegenerateController extends Controller
{
    public function __invoke(Request $request, TwoFactorRecoveryCodeService $recoveryCodeService): JsonResponse
    {
        if (! $request->user() instanceof User) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $plainCodes = $recoveryCodeService->generatePlainCodes();

        $request->user()->forceFill([
            'two_factor_recovery_codes' => $recoveryCodeService->hashCodes($plainCodes),
        ])->save();

        return response()->json([
            'data' => [
                'recovery_codes' => $plainCodes,
                'recovery_codes_text' => $recoveryCodeService->asText($plainCodes),
            ],
        ]);
    }
}
