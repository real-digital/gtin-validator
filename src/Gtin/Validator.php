<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

final class Validator
{
    public static function isValid(string $gtin): bool
    {
        try {
            Factory::create($gtin);
        } catch (NonNormalizable $nonNormalizableException) {
            return false;
        }

        return true;
    }
}
