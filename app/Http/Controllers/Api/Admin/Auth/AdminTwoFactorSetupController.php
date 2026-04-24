<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Support\Security\TotpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminTwoFactorSetupController extends Controller
{
    public function __invoke(Request $request, TotpService $totpService): JsonResponse
    {
        if (! $request->user() instanceof Admin) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $secret = $totpService->generateSecret();
        $recoveryCodes = collect(range(1, 8))
            ->map(fn (): string => Str::upper(Str::random(4).'-'.Str::random(4)))
            ->values();

        $request->user()->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => $recoveryCodes
                ->map(fn (string $recoveryCode): string => Hash::make($recoveryCode))
                ->all(),
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
                'recovery_codes' => $recoveryCodes->all(),
                'two_factor_enabled' => false,
            ],
        ]);
    }
}
