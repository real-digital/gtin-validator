<?php

declare(strict_types=1);

namespace Real\Validator\Gtin\Specification;

use Real\Validator\Gtin;

/**
 * @link https://www.gs1.org/services/how-calculate-check-digit-manually
 */
final class CheckSum implements Gtin\Specification
{
    /**
     * @inheritdoc
     */
    public function isSatisfied(Gtin $gtin): bool
    {
        $digits = str_split($gtin->padded());
        array_pop($digits);

        return $gtin->checkDigit() === $this->calculateModulo10CheckSum($digits);
    }

    /**
     * @inheritdoc
     */
    public function reasonCode(): int
    {
        return Gtin\NonNormalizable::CODE_CHECKSUM;
    }

    private function calculateModulo10CheckSum(array $digits): int
    {
        $digits = array_values($digits);

        $sum = 0;

        foreach ($digits as $i => $digit) {
            if ($i & 1) { //odd
                $sum += $digit;
            } else { //even
                $sum += $digit * 3;
            }
        }

        return 10 - ($sum % 10 ?: 10);
    }
}
