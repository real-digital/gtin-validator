<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class Gtin14Test extends TestCase implements GtinTest
{
    public function invalidProvider(): iterable
    {
        yield '9638507' => ['9638507', 1001];
        yield '10012345678903' => ['10012345678903', 1004];
        yield '10o12345678902' => ['10o12345678902', 1003];
        yield '123456789012345' => ['123456789012345', 1000];
        yield '96385074' => ['96385074', 1002];
        yield '096385074' => ['096385074', 1002];
        yield '00000096385074' => ['00000096385074', 1002];
        yield '614141999996' => ['614141999996', 1002];
        yield '0614141999996' => ['0614141999996', 1002];
        yield '00614141999996' => ['00614141999996', 1002];
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

    public function validProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902'];
        yield '17350053850252' => ['17350053850252'];
        yield '58937437933236' => ['58937437933236'];
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

    public function indicatorProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902', 1];
        yield '17350053850252' => ['17350053850252', 1];
        yield '58937437933236' => ['58937437933236', 5];
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

    public function keyProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902', '10012345678902'];
        yield '17350053850252' => ['17350053850252', '17350053850252'];
        yield '58937437933236' => ['58937437933236', '58937437933236'];
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

    public function paddedProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902', '10012345678902'];
        yield '17350053850252' => ['17350053850252', '17350053850252'];
        yield '58937437933236' => ['58937437933236', '58937437933236'];
    }

    /**
     * @dataProvider paddedProvider
     */
    public function testPadded(string $value, string $padded): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($padded, $gtin->padded());
    }

    public function checkDigitProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902', 2];
        yield '17350053850252' => ['17350053850252', 2];
        yield '58937437933236' => ['58937437933236', 6];
    }

    /**
     * @dataProvider checkDigitProvider
     */
    public function testCheckDigit(string $value, int $checkDigit): void
    {
        $gtin = new Gtin\Gtin14($value);

        self::assertSame($checkDigit, $gtin->checkDigit());
    }

    public function prefixProvider(): iterable
    {
        yield '10012345678902' => ['10012345678902', '001'];
        yield '17350053850252' => ['17350053850252', '735'];
        yield '58937437933236' => ['58937437933236', '893'];
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
