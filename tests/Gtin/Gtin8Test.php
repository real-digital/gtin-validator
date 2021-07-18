<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class Gtin8Test extends TestCase implements GtinTest
{
    public function invalidProvider(): iterable
    {
        yield '9638507' => ['9638507', 1001];
        yield '96385075' => ['96385075', 1004];
        yield '96385o74' => ['96385o74', 1003];
        yield '14085079' => ['14085079', 1005];
        yield '14000003' => ['14000003', 1005];
        yield '123456789012345' => ['123456789012345', 1000];
        yield '614141999996' => ['614141999996', 1002];
        yield '00614141999996' => ['00614141999996', 1002];
        yield '4006381333931' => ['4006381333931', 1002];
        yield '04006381333931' => ['04006381333931', 1002];
        yield '10012345678902' => ['10012345678902', 1002];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testValueIsNonNormalizable(string $value, int $reasonCode): void
    {
        $this->expectException(Gtin\NonNormalizable::class);
        $this->expectExceptionCode($reasonCode);

        new Gtin\Gtin8($value);
    }

    public function validProvider(): iterable
    {
        yield '96385074' => ['96385074'];
        yield '73127727' => ['73127727'];
    }

    /**
     * @dataProvider validProvider
     */
    public function testGtinInterfaceIsInherited(string $value): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertInstanceOf(Gtin::class, $gtin);
    }

    /**
     * @dataProvider validProvider
     */
    public function testLength(string $value): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame(8, $gtin->length());
    }

    /**
     * @dataProvider validProvider
     */
    public function testVariation(string $value): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame('GTIN-8', $gtin->variation());
    }

    /**
     * @dataProvider validProvider
     */
    public function testIndicator(string $value, int $indicator = 0): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($indicator, $gtin->indicator());
    }

    /**
     * @dataProvider validProvider
     */
    public function testOrigin(string $value): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($value, $gtin->origin());
    }

    public function keyProvider(): iterable
    {
        yield '96385074' => ['96385074', '96385074'];
        yield '096385074' => ['096385074', '96385074'];
        yield '0096385074' => ['0096385074', '96385074'];
        yield '00096385074' => ['00096385074', '96385074'];
        yield '000096385074' => ['000096385074', '96385074'];
        yield '0000096385074' => ['0000096385074', '96385074'];
        yield '00000096385074' => ['00000096385074', '96385074'];
    }

    /**
     * @dataProvider keyProvider
     */
    public function testKey(string $value, string $key): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($key, $gtin->key());
        self::assertSame(8, strlen($gtin->key()));
    }

    public function paddedProvider(): iterable
    {
        yield '96385074' => ['96385074', '00000096385074'];
        yield '73127727' => ['73127727', '00000073127727'];
    }

    /**
     * @dataProvider paddedProvider
     */
    public function testPadded(string $value, string $padded): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($padded, $gtin->padded());
    }

    public function checkDigitProvider(): iterable
    {
        yield '96385074' => ['96385074', 4];
        yield '73127727' => ['73127727', 7];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testCheckDigit(string $value, int $checkDigit): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($checkDigit, $gtin->checkDigit());
    }

    public function prefixProvider(): iterable
    {
        yield '96385074' => ['96385074', '963'];
        yield '73127727' => ['73127727', '731'];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testPrefix(string $value, string $prefix): void
    {
        $gtin = new Gtin\Gtin8($value);

        self::assertSame($prefix, $gtin->prefix());
    }
}
