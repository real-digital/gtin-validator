<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

interface GtinTest
{
    public function testValueIsNonNormalizable(string $value, int $reasonCode): void;

    public function testGtinInterfaceIsInherited(string $value): void;

    public function testLength(string $value): void;

    public function testVariation(string $value): void;

    public function testIndicator(string $value, int $indicator): void;

    public function testOrigin(string $value): void;

    public function testKey(string $value, string $key): void;

    public function testPadded(string $value, string $padded): void;

    public function testCheckDigit(string $value, int $checkDigit): void;

    public function testPrefix(string $value, string $prefix): void;
}
