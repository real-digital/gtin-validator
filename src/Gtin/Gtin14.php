<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

final class Gtin14 extends General
{
    /**
     * @inheritdoc
     */
    public function variation(): string
    {
        return 'GTIN-14';
    }

    /**
     * @inheritdoc
     */
    public function length(): int
    {
        return 14;
    }

    /**
     * @inheritdoc
     */
    public function prefix(): string
    {
        return substr($this->padded(), 1, 3);
    }
}
