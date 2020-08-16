<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class LengthTest extends TestCase
{
    public function testSpecificationInterfaceIsInherited(): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertInstanceOf(Gtin\Specification::class, $specification);
    }

    public function lengthProvider(): array
    {
        return [
            ['1', 1],
            ['12', 2],
            ['123', 3],
            ['1234', 4],
            ['12345', 5],
            ['123456', 6],
            ['1234567', 7],
            ['12345678', 8],
            ['123456789', 12],
            ['0123456789', 12],
            ['00123456789', 12],
            ['000123456789', 12],
            ['100123456789', 12],
            ['100123456789', 12],
            ['0000123456789', 12],
            ['0000123456789', 12],
            ['1000123456789', 13],
            ['10000123456789', 14],
            ['123456789012345', 15],
            ['1234567890123456', 16],
            ['12345678901234567', 17],
        ];
    }

    /**
     * @dataProvider lengthProvider
     */
    public function testCalculate(string $value, int $length): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertSame($length, $specification->calculate($value));
    }

    public function satisfactionProvider(): array
    {
        return [
            ['1', 1, true],
            ['12', 2, true],
            ['123', 3, true],
            ['1234', 4, true],
            ['12345', 5, true],
            ['123456', 6, true],
            ['1234567', 7, true],
            ['01234567', 8, true],
            ['0123456789', 12, true],
            ['012345678', 9, false],
            ['00123456789', 12, true],
            ['0012345678', 10, false],
            ['01012345678', 12, true],
            ['01012345678', 11, false],
            ['0000123456789', 12, true],
            ['0000123456789', 13, false],
            ['1000123456789', 13, true],
            ['10000123456789', 14, true],
            ['123456789012345', 15, true],
            ['1234567890123456', 16, true],
            ['12345678901234567', 17, true],
        ];
    }

    /**
     * @dataProvider satisfactionProvider
     */
    public function testIsSatisfied(string $value, int $length, bool $isSatisfied): void
    {
        $specification = new Gtin\Specification\Length();

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, [
            'origin' => $value,
            'length' => $length,
        ]);

        self::assertSame($isSatisfied, $specification->isSatisfied($gtin));
    }

    public function invalidValueWithCodeProvider(): array
    {
        return [
            ['1', 1001],
            ['12', 1001],
            ['123', 1001],
            ['1234', 1001],
            ['12345', 1001],
            ['123456', 1001],
            ['1234567', 1001],
            ['123456789', 1002],
            ['0123456789', 1002],
            ['1234567890', 1002],
            ['01234567890', 1002],
            ['00123456789', 1002],
            ['11234567890', 1002],
            ['011234567890', 1002],
            ['0011234567890', 1002],
            ['00001234567890', 1002],
            ['123456789012345', 1000],
            ['1234567890123456', 1000],
            ['12345678901234567', 1000],
        ];
    }

    /**
     * @dataProvider invalidValueWithCodeProvider
     */
    public function testCalculateChangesReasonCode(string $value, int $reasonCode): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertSame(1002, $specification->reasonCode());

        $specification->calculate($value);

        self::assertSame($reasonCode, $specification->reasonCode());
    }

    /**
     * @dataProvider invalidValueWithCodeProvider
     */
    public function testIsSatisfiedChangesReasonCode(string $value, int $reasonCode): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertSame(1002, $specification->reasonCode());

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, ['origin' => $value]);

        $specification->isSatisfied($gtin);

        self::assertSame($reasonCode, $specification->reasonCode());
    }
}
