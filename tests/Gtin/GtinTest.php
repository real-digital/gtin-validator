<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

interface GtinTest
{
    public function testValueIsNonNormalizable(string $value, int $reasonCode);

    public function testGtinInterfaceIsInherited(string $value);

    public function testLength(string $value);

    public function testVariation(string $value);

    public function testIndicator(string $value, int $indicator);

    public function testOrigin(string $value);

    public function testKey(string $value, string $key);

    public function testPadded(string $value, string $padded);

    public function testCheckDigit(string $value, int $checkDigit);

    public function testPrefix(string $value, string $prefix);
}
