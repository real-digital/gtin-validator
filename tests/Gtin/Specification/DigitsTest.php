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

    public function digitsProvider(): iterable
    {
        yield '1' => ['1', true];
        yield '123' => ['123', true];
        yield '42' => ['42', true];
        yield '012' => ['012', true];
        yield '0' => ['0', true];
        yield '0000000000000000000000' => ['0000000000000000000000', true];
        yield '-1' => ['-1', false];
        yield '-100' => ['-100', false];
        yield '25-4' => ['25-4', false];
        yield '' => ['', false];
        yield ' ' => [' ', false];
        yield 'chr(9)' => [chr(9), false];
        yield '\n' => ["\n", false];
        yield 'test' => ['test', false];
        yield '123s' => ['123s', false];
        yield 's123' => ['s123', false];
        yield '0xff' => ['0xff', false];
        yield '0b11' => ['0b11', false];
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
