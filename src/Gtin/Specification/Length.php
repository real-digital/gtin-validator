<?php

declare(strict_types=1);

namespace Real\Validator\Gtin\Specification;

use Real\Validator\Gtin;

final class Length implements Gtin\Specification
{
    /** @var int */
    private $reasonCode = Gtin\NonNormalizable::CODE_LENGTH_KEY;

    /**
     * @inheritdoc
     */
    public function isSatisfied(Gtin $gtin): bool
    {
        return $this->calculate($gtin->origin()) === $gtin->length();
    }

    /**
     * @inheritdoc
     */
    public function reasonCode(): int
    {
        return $this->reasonCode;
    }

    public function calculate(string $value): int
    {
        $length = strlen($value);

        switch (true) {
            case $length > 14:
                $this->reasonCode = Gtin\NonNormalizable::CODE_LENGTH_14;
                break;
            case $length < 8:
                $this->reasonCode = Gtin\NonNormalizable::CODE_LENGTH_8;
                break;
            default:
                $this->reasonCode = Gtin\NonNormalizable::CODE_LENGTH_KEY;
                $length = $this->calculateTrimmed($value);
                break;
        }

        return $length;
    }

    /**
     * Certain rules ensure that there is no ambiguity:
     *
     * The first digit of a GTIN-14 is never a "0" digit, so there is no possibility of confusing a GTIN-14
     * for a GTIN-13, GTIN-12, or GTIN-8 written in 14-digit format. (A 14-digit code beginning with
     * a zero is technically not a GTIN-14, but is instead a GTIN-13, GTIN-12, or GTIN-8 padded to 14 digits.)
     *
     * The first digit of a GTIN-13 is never a "0" digit, so there is no possibility of confusing a
     * GTIN-13 for a GTIN-12 or GTIN-8. (A 13-digit code beginning with a zero is technically not a GTIN-13,
     * but is instead a GTIN-12 or GTIN-8 padded to 13 digits.)
     *
     * In a GTIN-12, at least one of the digits N3, N4, N5, and N6 (as written in the table) must be non-zero,
     * so there is no possibility of confusing a GTIN-12 for a GTIN-8.
     */
    private function calculateTrimmed(string $value): int
    {
        $trimmed = ltrim($value, '0');
        $length = strlen($trimmed);

        switch ($length) {
            default:
                $length = 8;
                break;
            case 9:
            case 10:
            case 11:
            case 12:
                $length = 12;
                break;
            case 13:
            case 14:
                break;
        }

        return $length;
    }
}
