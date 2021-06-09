<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

use Real\Validator\Gtin;

final class Factory
{
    /**
     * @throws NonNormalizable
     */
    public static function create(string $value): Gtin
    {
        $length = new Specification\Length();

        switch ($length->calculate($value)) {
            case 8:
                return new Gtin8($value);
            case 12:
                return new Gtin12($value);
            case 13:
                return new Gtin13($value);
            case 14:
                return new Gtin14($value);
            default:
                throw new NonNormalizable($value, $length);
        }
    }

    public static function isValid(string $value): bool
    {
        try {
            self::create($value);
        } catch (NonNormalizable $e) {
            return false;
        }

        return true;
    }
}
