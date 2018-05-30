<?php
declare(strict_types=1);

namespace Real\Validator\Gtin;

use Real\Validator\UserError;

class NonNormalizable extends \InvalidArgumentException implements UserError
{
    # @formatter:off
    public const CODE_LENGTH_14         = 1000;
    public const CODE_LENGTH_8          = 1001;
    public const CODE_LENGTH_KEY        = 1002;
    public const CODE_DIGITS            = 1003;
    public const CODE_CHECKSUM          = 1004;
    public const CODE_PREFIX            = 1005;
    # @formatter:on

    /** @var string */
    private $value;

    /** @var int */
    private $reasonCode;

    public function __construct(string $value, Specification $specification, \Throwable $previous = null)
    {
        $this->value = $value;
        $this->reasonCode = $specification->reasonCode();

        parent::__construct($this->reasonMessage($this->reasonCode), $this->reasonCode, $previous);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function reasonMessage(int $reasonCode): string
    {
        switch ($reasonCode) {
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
            default:
                $message = 'Invalid argument has been passed';
                break;
        }

        return $message;
    }

    /**
     * @inheritdoc
     */
    public function messageKey(): string
    {
        return sprintf('GTIN %%gtin%% is not valid. %s', $this->getMessage());
    }

    /**
     * @inheritdoc
     */
    public function messageData(): array
    {
        return ['%gtin%' => $this->value];
    }
}
