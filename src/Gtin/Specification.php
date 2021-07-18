<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

use Real\Validator\Gtin;

interface Specification
{
    /**
     * Checks whether a candidate GTIN matches the specification
     */
    public function isSatisfied(Gtin $gtin): bool;

    /**
     * A unique technical code representing a particular reason why the specification has not been satisfied
     */
    public function reasonCode(): int;
}
