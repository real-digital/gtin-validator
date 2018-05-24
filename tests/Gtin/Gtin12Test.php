<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class Gtin12Test extends TestCase implements GtinTest
{
    public function invalidProvider(): array
    {
        return [
            ['9638507', 1001],
            ['614141999997', 1004],
            ['61414I999996', 1003],
            ['123456789012345', 1000],
            ['96385074', 1002],
            ['4006381333931', 1002],
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

        new Gtin\Gtin12($value);
    }


    public function validProvider(): array
    {
        return [
            ['614141991'],
            ['0614141991'],
            ['00614141991'],
            ['614141999996'],
            ['942217200524'],
        ];
    }

    /**
     * @dataProvider validProvider
     */
    public function testGtinInterfaceIsInherited(string $value)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertInstanceOf(Gtin::class, $gtin);
    }

    /**
     * @dataProvider validProvider
     */
    public function testLength(string $value)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame(12, $gtin->length());
    }

    /**
     * @dataProvider validProvider
     */
    public function testVariation(string $value)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame('GTIN-12', $gtin->variation());
    }

    /**
     * @dataProvider validProvider
     */
    public function testIndicator(string $value, int $indicator = 0)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($indicator, $gtin->indicator());
    }

    /**
     * @dataProvider validProvider
     */
    public function testOrigin(string $value)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($value, $gtin->origin());
    }

    public function keyProvider(): array
    {
        return [
            ['614141999996', '614141999996'],
            ['0614141999996', '614141999996'],
            ['00614141999996', '614141999996'],
        ];
    }

    /**
     * @dataProvider keyProvider
     */
    public function testKey(string $value, string $key)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($key, $gtin->key());
        self::assertSame(12, strlen($gtin->key()));
    }

    public function paddedProvider(): array
    {
        return [
            ['614141999996', '00614141999996'],
            ['942217200524', '00942217200524'],
        ];
    }

    /**
     * @dataProvider paddedProvider
     */
    public function testPadded(string $value, string $padded)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($padded, $gtin->padded());
    }

    public function checkDigitProvider(): array
    {
        return [
            ['614141999996', 6],
            ['942217200524', 4],
        ];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testCheckDigit(string $value, int $checkDigit)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($checkDigit, $gtin->checkDigit());
    }

    public function prefixProvider(): array
    {
        return [
            ['614141999996', '061'],
            ['942217200524', '094'],
        ];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testPrefix(string $value, string $prefix)
    {
        $gtin = new Gtin\Gtin12($value);

        self::assertSame($prefix, $gtin->prefix());
    }
}
