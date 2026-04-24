<?php

namespace App\Support\Security;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TwoFactorRecoveryCodeService
{
    /**
     * @return array<int, string>
     */
    public function generatePlainCodes(int $count = 8): array
    {
        return collect(range(1, $count))
            ->map(fn (): string => Str::upper(Str::random(4).'-'.Str::random(4)))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, string>  $plainCodes
     * @return array<int, string>
     */
    public function hashCodes(array $plainCodes): array
    {
        return collect($plainCodes)
            ->map(fn (string $recoveryCode): string => Hash::make($recoveryCode))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, string>  $hashedCodes
     * @return array{consumed: bool, remaining_codes: array<int, string>}
     */
    public function consumeCode(array $hashedCodes, string $providedCode): array
    {
        $normalizedCode = Str::upper(trim($providedCode));

        if ($normalizedCode === '') {
            return [
                'consumed' => false,
                'remaining_codes' => $hashedCodes,
            ];
        }

        foreach ($hashedCodes as $index => $hashedCode) {
            if (Hash::check($normalizedCode, $hashedCode)) {
                unset($hashedCodes[$index]);

                return [
                    'consumed' => true,
                    'remaining_codes' => array_values($hashedCodes),
                ];
            }
        }

        return [
            'consumed' => false,
            'remaining_codes' => $hashedCodes,
        ];
    }

    /**
     * @param  array<int, string>  $plainCodes
     */
    public function asText(array $plainCodes): string
    {
        return implode(PHP_EOL, $plainCodes).PHP_EOL;
    }
}
