<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin\Specification;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class DigitsTest extends TestCase
{
    public function testSpecificationInterfaceIsInherited(): void
    {
        $specification = new Gtin\Specification\Digits();

        self::assertInstanceOf(Gtin\Specification::class, $specification);
    }

    public function testReasonCode(): void
    {
        $specification = new Gtin\Specification\Digits();

        self::assertSame(1003, $specification->reasonCode());
    }

    public function digitsProvider(): array
    {
        return [
            ['1', true],
            ['123', true],
            ['42', true],
            ['012', true],
            ['0', true],
            ['0000000000000000000000', true],
            ['-1', false],
            ['-100', false],
            ['25-4', false],
            ['', false],
            [' ', false],
            [chr(9), false],
            ["\n", false],
            ['test', false],
            ['123s', false],
            ['s123', false],
            ['0xff', false],
            ['0b11', false],
        ];
    }

    /**
     * @dataProvider digitsProvider
     */
    public function testIsSatisfied(string $value, bool $isSatisfied): void
    {
        $specification = new Gtin\Specification\Digits();

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, ['origin' => $value]);

        self::assertSame($isSatisfied, $specification->isSatisfied($gtin));
    }
}
