<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

final class Gtin8 extends General
{
    /**
     * @inheritdoc
     */
    public function variation(): string
    {
        return 'GTIN-8';
    }

    /**
     * @inheritdoc
     */
    public function length(): int
    {
        return 8;
    }

    /**
     * @inheritdoc
     */
    public function prefix(): string
    {
        return (string) substr($this->padded(), 6, 3);
    }
}
