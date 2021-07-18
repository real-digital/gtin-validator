<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class FactoryTest extends TestCase
{
    public function validValueProvider(): iterable
    {
        yield '96385074' => ['96385074', Gtin\Gtin8::class];
        yield '73127727' => ['73127727', Gtin\Gtin8::class];
        yield '073127727' => ['073127727', Gtin\Gtin8::class];
        yield '0073127727' => ['0073127727', Gtin\Gtin8::class];
        yield '00073127727' => ['00073127727', Gtin\Gtin8::class];
        yield '000073127727' => ['000073127727', Gtin\Gtin8::class];
        yield '0000073127727' => ['0000073127727', Gtin\Gtin8::class];
        yield '614141991' => ['614141991', Gtin\Gtin12::class];
        yield '0614141991' => ['0614141991', Gtin\Gtin12::class];
        yield '00614141991' => ['00614141991', Gtin\Gtin12::class];
        yield '123601057072' => ['123601057072', Gtin\Gtin12::class];
        yield '725272730706' => ['725272730706', Gtin\Gtin12::class];
        yield '0725272730706' => ['0725272730706', Gtin\Gtin12::class];
        yield '4006381333931' => ['4006381333931', Gtin\Gtin13::class];
        yield '5010677012638' => ['5010677012638', Gtin\Gtin13::class];
        yield '05010677012638' => ['05010677012638', Gtin\Gtin13::class];
        yield '10012345678902' => ['10012345678902', Gtin\Gtin14::class];
        yield '58937437933236' => ['58937437933236', Gtin\Gtin14::class];
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

    public function invalidValueProvider(): iterable
    {
        yield '1' => ['1', 1001];
        yield '12' => ['12', 1001];
        yield '123' => ['123', 1001];
        yield '1234' => ['1234', 1001];
        yield '12345' => ['12345', 1001];
        yield '123456' => ['123456', 1001];
        yield '1234567' => ['1234567', 1001];
        yield '123456789012345' => ['123456789012345', 1000];
        yield '1234567890123456' => ['1234567890123456', 1000];
        yield '12345678901234567' => ['12345678901234567', 1000];
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
