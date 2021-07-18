<?php

declare(strict_types=1);

namespace Real\Validator\Gtin;

class NonNormalizable extends \InvalidArgumentException
{
    public const CODE_LENGTH_14 = 1000;
    public const CODE_LENGTH_8 = 1001;
    public const CODE_LENGTH_KEY = 1002;
    public const CODE_DIGITS = 1003;
    public const CODE_CHECKSUM = 1004;
    public const CODE_PREFIX = 1005;

    /** @var string */
    private $value;

    public function __construct(string $value, Specification $specification, ?\Throwable $previous = null)
    {
        $this->value = $value;

        parent::__construct($this->reasonMessage($specification), $specification->reasonCode(), $previous);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function reasonMessage(Specification $specification): string
    {
        switch ($specification->reasonCode()) {
            case self::CODE_LENGTH_14:
                $message = 'Length is greater than 14 characters';
                break;
            case self::CODE_LENGTH_8:
                $message = 'Length is less than 8 characters';
                break;
            case self::CODE_LENGTH_KEY:
                $message = 'Length is not corresponding GTIN variation';
                break;
            case self::CODE_DIGITS:
                $message = 'Some of the characters are not digits';
                break;
            case self::CODE_PREFIX:
                $message = 'Prefix is invalid';
                break;
            case self::CODE_CHECKSUM:
                $message = 'Checksum is invalid';
                break;
            default:
                $message = 'Invalid argument has been passed';
                break;
        }

        return $message;
    }
}
