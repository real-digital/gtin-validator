<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class Gtin14Test extends TestCase implements GtinTest
{
    public function invalidProvider(): array
    {
        return [
            ['9638507', 1001],
            ['10012345678903', 1004],
            ['10o12345678902', 1003],
            ['123456789012345', 1000],
            ['96385074', 1002],
            ['096385074', 1002],
            ['00000096385074', 1002],
            ['614141999996', 1002],
            ['0614141999996', 1002],
            ['00614141999996', 1002],
        ];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testValueIsNonNormalizable(string $value, int $reasonCode): void
    {
        $this->expectException(Gtin\NonNormalizable::class);
        $this->expectExceptionCode($reasonCode);

        new Gtin\Gtin14($value);
    }


    public function validProvider(): array
    {
        return [
            ['10012345678902'],
            ['17350053850252'],
            ['58937437933236'],
        ];
    }

    /**
     * @dataProvider validProvider
     */
    public function testGtinInterfaceIsInherited(string $value): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertInstanceOf(Gtin::class, $gtin);
    }

    /**
     * @dataProvider validProvider
     */
    public function testLength(string $value): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame(14, $gtin->length());
    }

    /**
     * @dataProvider validProvider
     */
    public function testVariation(string $value): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame('GTIN-14', $gtin->variation());
    }

    public function indicatorProvider(): array
    {
        return [
            ['10012345678902', 1],
            ['17350053850252', 1],
            ['58937437933236', 5],
        ];
    }

    /**
     * @dataProvider indicatorProvider
     */
    public function testIndicator(string $value, int $indicator): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($indicator, $gtin->indicator());
    }

    /**
     * @dataProvider validProvider
     */
    public function testOrigin(string $value): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($value, $gtin->origin());
    }

    public function keyProvider(): array
    {
        return [
            ['10012345678902', '10012345678902'],
            ['17350053850252', '17350053850252'],
            ['58937437933236', '58937437933236'],
        ];
    }

    /**
     * @dataProvider keyProvider
     */
    public function testKey(string $value, string $key): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($key, $gtin->key());
        self::assertSame(14, strlen($gtin->key()));
    }

    public function paddedProvider(): array
    {
        return [
            ['10012345678902', '10012345678902'],
            ['17350053850252', '17350053850252'],
            ['58937437933236', '58937437933236'],
        ];
    }

    /**
     * @dataProvider paddedProvider
     */
    public function testPadded(string $value, string $padded): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($padded, $gtin->padded());
    }

    public function checkDigitProvider(): array
    {
        return [
            ['10012345678902', 2],
            ['17350053850252', 2],
            ['58937437933236', 6],
        ];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testCheckDigit(string $value, int $checkDigit): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($checkDigit, $gtin->checkDigit());
    }

    public function prefixProvider(): array
    {
        return [
            ['10012345678902', '001'],
            ['17350053850252', '735'],
            ['58937437933236', '893'],
        ];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testPrefix(string $value, string $prefix): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($prefix, $gtin->prefix());
    }
}
