<?php

declare(strict_types=1);

namespace Real\Validator\Gtin\Specification;

use Real\Validator\Gtin;

final class Digits implements Gtin\Specification
{
    /**
     * @inheritdoc
     */
    public function isSatisfied(Gtin $gtin): bool
    {
        return ctype_digit($gtin->origin());
    }

    /**
     * @inheritdoc
     */
    public function reasonCode(): int
    {
        return Gtin\NonNormalizable::CODE_DIGITS;
    }
}
