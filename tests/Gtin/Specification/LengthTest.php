<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin\Specification;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class LengthTest extends TestCase
{
    public function testSpecificationInterfaceIsInherited(): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertInstanceOf(Gtin\Specification::class, $specification);
    }

    public function lengthProvider(): iterable
    {
        yield '1' => ['1', 1];
        yield '12' => ['12', 2];
        yield '123' => ['123', 3];
        yield '1234' => ['1234', 4];
        yield '12345' => ['12345', 5];
        yield '123456' => ['123456', 6];
        yield '1234567' => ['1234567', 7];
        yield '12345678' => ['12345678', 8];
        yield '123456789' => ['123456789', 12];
        yield '0123456789' => ['0123456789', 12];
        yield '00123456789' => ['00123456789', 12];
        yield '000123456789' => ['000123456789', 12];
        yield '100123456789' => ['100123456789', 12];
        yield '0000123456789' => ['0000123456789', 12];
        yield '1000123456789' => ['1000123456789', 13];
        yield '10000123456789' => ['10000123456789', 14];
        yield '123456789012345' => ['123456789012345', 15];
        yield '1234567890123456' => ['1234567890123456', 16];
        yield '12345678901234567' => ['12345678901234567', 17];
    }

    /**
     * @dataProvider lengthProvider
     */
    public function testCalculate(string $value, int $length): void
    {
        $specification = new Gtin\Specification\Length();

        self::assertSame($length, $specification->calculate($value));
    }

    public function satisfactionProvider(): iterable
    {
        yield '1' => ['1', 1, true];
        yield '12' => ['12', 2, true];
        yield '123' => ['123', 3, true];
        yield '1234' => ['1234', 4, true];
        yield '12345' => ['12345', 5, true];
        yield '123456' => ['123456', 6, true];
        yield '1234567' => ['1234567', 7, true];
        yield '01234567' => ['01234567', 8, true];
        yield '0123456789' => ['0123456789', 12, true];
        yield '012345678' => ['012345678', 9, false];
        yield '00123456789' => ['00123456789', 12, true];
        yield '0012345678' => ['0012345678', 10, false];
        yield '01012345678_12' => ['01012345678', 12, true];
        yield '01012345678_11' => ['01012345678', 11, false];
        yield '0000123456789_12' => ['0000123456789', 12, true];
        yield '0000123456789_13' => ['0000123456789', 13, false];
        yield '1000123456789' => ['1000123456789', 13, true];
        yield '10000123456789' => ['10000123456789', 14, true];
        yield '123456789012345' => ['123456789012345', 15, true];
        yield '1234567890123456' => ['1234567890123456', 16, true];
        yield '12345678901234567' => ['12345678901234567', 17, true];
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

    public function invalidValueWithCodeProvider(): iterable
    {
        yield '1' => ['1', 1001];
        yield '12' => ['12', 1001];
        yield '123' => ['123', 1001];
        yield '1234' => ['1234', 1001];
        yield '12345' => ['12345', 1001];
        yield '123456' => ['123456', 1001];
        yield '1234567' => ['1234567', 1001];
        yield '123456789' => ['123456789', 1002];
        yield '0123456789' => ['0123456789', 1002];
        yield '1234567890' => ['1234567890', 1002];
        yield '01234567890' => ['01234567890', 1002];
        yield '00123456789' => ['00123456789', 1002];
        yield '11234567890' => ['11234567890', 1002];
        yield '011234567890' => ['011234567890', 1002];
        yield '0011234567890' => ['0011234567890', 1002];
        yield '00001234567890' => ['00001234567890', 1002];
        yield '123456789012345' => ['123456789012345', 1000];
        yield '1234567890123456' => ['1234567890123456', 1000];
        yield '12345678901234567' => ['12345678901234567', 1000];
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
