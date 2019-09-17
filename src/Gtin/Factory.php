<?php
declare(strict_types=1);

namespace Real\Validator\Gtin;

use Real\Validator\Gtin;

final class Factory
{
    /**
     * @param string $value
     * @param array $customPrefixes
     *
     * @return Gtin
     */
    public static function create(string $value, array $customPrefixes = []): Gtin
    {
        $length = new Specification\Length();

        switch ($length->calculate($value)) {
            case 8:
                return new Gtin8($value, $customPrefixes);
            case 12:
                return new Gtin12($value, $customPrefixes);
            case 13:
                return new Gtin13($value, $customPrefixes);
            case 14:
                return new Gtin14($value, $customPrefixes);
            default:
                throw new NonNormalizable($value, $length);
        }
    }
}
