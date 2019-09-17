<?php
declare(strict_types=1);

namespace Real\Validator\Gtin;

use Real\Validator;

abstract class General implements Validator\Gtin
{
    /** @var string */
    private $origin;

    /**
     * @param string $value
     * @param array $customPrefixes
     */
    final public function __construct(string $value, array $customPrefixes = [])
    {
        $this->origin = $value;

        $this->satisfyBy(new Specification\Digits);
        $this->satisfyBy(new Specification\Length);
        $this->satisfyBy(new Specification\CheckSum);
        $this->satisfyBy(new Specification\Prefix($customPrefixes));
    }

    /**
     * @throws NonNormalizable
     */
    private function satisfyBy(Specification $specification): void
    {
        if (!$specification->isSatisfied($this)) {
            throw new NonNormalizable($this->origin, $specification);
        }
    }

    /**
     * @inheritdoc
     */
    final public function origin(): string
    {
        return $this->origin;
    }

    /**
     * @inheritdoc
     */
    final public function checkDigit(): int
    {
        $digit = substr($this->origin, -1);

        return (int)$digit;
    }

    /**
     * @inheritdoc
     */
    final public function padded(): string
    {
        return str_pad($this->origin, 14, '0', STR_PAD_LEFT);
    }

    /**
     * @inheritdoc
     */
    final public function key(): string
    {
        $trimmed = ltrim($this->origin, '0');

        return str_pad($trimmed, $this->length(), '0', STR_PAD_LEFT);
    }

    /**
     * @inheritdoc
     */
    final public function indicator(): int
    {
        $indicator = substr($this->padded(), 0, 1);

        return (int)$indicator;
    }
}
