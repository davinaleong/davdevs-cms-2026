<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Support\Security\TwoFactorRecoveryCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTwoFactorRecoveryCodesRegenerateController extends Controller
{
    public function __invoke(Request $request, TwoFactorRecoveryCodeService $recoveryCodeService): JsonResponse
    {
        if (! $request->user() instanceof Admin) {
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
