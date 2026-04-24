<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Security\TwoFactorRecoveryCodeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TwoFactorRecoveryCodesDownloadController extends Controller
{
    public function __invoke(Request $request, TwoFactorRecoveryCodeService $recoveryCodeService): StreamedResponse
    {
        abort_unless($request->user() instanceof User, 403);

        $plainCodes = $recoveryCodeService->generatePlainCodes();

        $request->user()->forceFill([
            'two_factor_recovery_codes' => $recoveryCodeService->hashCodes($plainCodes),
        ])->save();

        $filename = 'user-recovery-codes.txt';
        $content = $recoveryCodeService->asText($plainCodes);

        return response()->streamDownload(static function () use ($content): void {
            echo $content;
        }, $filename, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
