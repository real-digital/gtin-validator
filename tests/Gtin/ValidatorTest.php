<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider validValueProvider
     *
     * @param string $gtin
     */
    public function testIsValidWithValidValues(string $gtin)
    {
        $this->assertTrue(
            Gtin\Validator::isValid($gtin)
        );
    }

    /**
     * @dataProvider invalidValueProvider
     *
     * @param string $gtin
     */
    public function testIsValidWithInvalidValues(string $gtin)
    {
        $this->assertFalse(
            Gtin\Validator::isValid($gtin)
        );
    }

    public function validValueProvider(): array
    {
        return [
            ['96385074'],
            ['73127727'],
            ['073127727'],
            ['0073127727'],
            ['00073127727'],
            ['000073127727'],
            ['0000073127727'],
            ['614141991'],
            ['0614141991'],
            ['00614141991'],
            ['123601057072'],
            ['725272730706'],
            ['0725272730706'],
            ['4006381333931'],
            ['5010677012638'],
            ['05010677012638'],
            ['10012345678902'],
            ['58937437933236'],
        ];
    }

    public function invalidValueProvider(): array
    {
        return [
            ['1'],
            ['12'],
            ['123'],
            ['1234'],
            ['12345'],
            ['123456'],
            ['1234567'],
            ['123456789012345'],
            ['1234567890123456'],
            ['12345678901234567'],
        ];
    }
}
