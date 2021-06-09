<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class FactoryTest extends TestCase
{
    public function validValueProvider(): array
    {
        return [
            ['96385074', Gtin\Gtin8::class],
            ['73127727', Gtin\Gtin8::class],
            ['073127727', Gtin\Gtin8::class],
            ['0073127727', Gtin\Gtin8::class],
            ['00073127727', Gtin\Gtin8::class],
            ['000073127727', Gtin\Gtin8::class],
            ['0000073127727', Gtin\Gtin8::class],
            ['614141991', Gtin\Gtin12::class],
            ['0614141991', Gtin\Gtin12::class],
            ['00614141991', Gtin\Gtin12::class],
            ['123601057072', Gtin\Gtin12::class],
            ['725272730706', Gtin\Gtin12::class],
            ['0725272730706', Gtin\Gtin12::class],
            ['4006381333931', Gtin\Gtin13::class],
            ['5010677012638', Gtin\Gtin13::class],
            ['05010677012638', Gtin\Gtin13::class],
            ['10012345678902', Gtin\Gtin14::class],
            ['58937437933236', Gtin\Gtin14::class],
        ];
    }

    /**
     * @dataProvider validValueProvider
     *
     * @param class-string<Gtin> $fqcn
     */
    public function testSuccessfulCreation(string $value, string $fqcn): void
    {
        $gtin = Gtin\Factory::create($value);

        self::assertInstanceOf($fqcn, $gtin);
    }

    /**
     * @dataProvider validValueProvider
     */
    public function testIsValid(string $value): void
    {
        self::assertTrue(Gtin\Factory::isValid($value));
    }

    public function invalidValueProvider(): array
    {
        return [
            ['1', 1001],
            ['12', 1001],
            ['123', 1001],
            ['1234', 1001],
            ['12345', 1001],
            ['123456', 1001],
            ['1234567', 1001],
            ['123456789012345', 1000],
            ['1234567890123456', 1000],
            ['12345678901234567', 1000],
        ];
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function testExceptionIsThrown(string $value, int $reasonCode): void
    {
        $this->expectException(Gtin\NonNormalizable::class);
        $this->expectExceptionCode($reasonCode);

        Gtin\Factory::create($value);
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function testIsNotValid(string $value): void
    {
        self::assertFalse(Gtin\Factory::isValid($value));
    }
}
