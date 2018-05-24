<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class Gtin8Test extends TestCase implements GtinTest
{
    public function invalidProvider(): array
    {
        return [
            ['9638507', 1001],
            ['96385075', 1004],
            ['96385o74', 1003],
            ['00385077', 1005],
            ['00085076', 1005],
            ['05385072', 1005],
            ['00000000', 1005],
            ['000000000', 1005],
            ['0000000000', 1005],
            ['00000000000', 1005],
            ['000000000000', 1005],
            ['0000000000000', 1005],
            ['00000000000000', 1005],
            ['123456789012345', 1000],
            ['614141999996', 1002],
            ['00614141999996', 1002],
            ['4006381333931', 1002],
            ['04006381333931', 1002],
            ['04006381333931', 1002],
            ['04006381333931', 1002],
            ['10012345678902', 1002],
        ];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testValueIsNonNormalizable(string $value, int $reasonCode)
    {
        $this->expectException(Gtin\NonNormalizable::class);
        $this->expectExceptionCode($reasonCode);

        new Gtin\Gtin8($value);
    }


    public function validProvider(): array
    {
        return [
            ['96385074'],
            ['73127727'],
        ];
    }

    /**
     * @dataProvider validProvider
     */
    public function testGtinInterfaceIsInherited(string $value)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertInstanceOf(Gtin::class, $gtin);
    }

    /**
     * @dataProvider validProvider
     */
    public function testLength(string $value)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame(8, $gtin->length());
    }

    /**
     * @dataProvider validProvider
     */
    public function testVariation(string $value)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame('GTIN-8', $gtin->variation());
    }

    /**
     * @dataProvider validProvider
     */
    public function testIndicator(string $value, int $indicator = 0)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($indicator, $gtin->indicator());
    }

    /**
     * @dataProvider validProvider
     */
    public function testOrigin(string $value)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($value, $gtin->origin());
    }

    public function keyProvider(): array
    {
        return [
            ['96385074', '96385074'],
            ['096385074', '96385074'],
            ['0096385074', '96385074'],
            ['00096385074', '96385074'],
            ['000096385074', '96385074'],
            ['0000096385074', '96385074'],
            ['00000096385074', '96385074'],
        ];
    }

    /**
     * @dataProvider keyProvider
     */
    public function testKey(string $value, string $key)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($key, $gtin->key());
        self::assertSame(8, strlen($gtin->key()));
    }

    public function paddedProvider(): array
    {
        return [
            ['96385074', '00000096385074'],
            ['73127727', '00000073127727'],
        ];
    }

    /**
     * @dataProvider paddedProvider
     */
    public function testPadded(string $value, string $padded)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($padded, $gtin->padded());
    }

    public function checkDigitProvider(): array
    {
        return [
            ['96385074', 4],
            ['73127727', 7],
        ];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testCheckDigit(string $value, int $checkDigit)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($checkDigit, $gtin->checkDigit());
    }

    public function prefixProvider(): array
    {
        return [
            ['96385074', '963'],
            ['73127727', '731'],
        ];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testPrefix(string $value, string $prefix)
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($prefix, $gtin->prefix());
    }
}
