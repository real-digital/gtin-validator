<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

final class Gtin12 extends General
{
    /**
     * @inheritdoc
     */
    public function variation(): string
    {
        return 'GTIN-12';
    }

    /**
     * @inheritdoc
     */
    public function length(): int
    {
        return 12;
    }

    /**
     * @inheritdoc
     */
    public function prefix(): string
    {
        return substr($this->padded(), 1, 3);
    }
}
