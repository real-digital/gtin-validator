<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

final class Gtin13 extends General
{
    /**
     * @inheritdoc
     */
    public function variation(): string
    {
        return 'GTIN-13';
    }

    /**
     * @inheritdoc
     */
    public function length(): int
    {
        return 13;
    }

    /**
     * @inheritdoc
     */
    public function prefix(): string
    {
        return (string) substr($this->padded(), 1, 3);
    }
}
