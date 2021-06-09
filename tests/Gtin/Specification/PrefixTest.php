<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin\Specification;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class PrefixTest extends TestCase
{
    public function testSpecificationInterfaceIsInherited(): void
    {
        $specification = new Gtin\Specification\Prefix();

        self::assertInstanceOf(Gtin\Specification::class, $specification);
    }

    public function testReasonCode(): void
    {
        $specification = new Gtin\Specification\Prefix();

        self::assertSame(1005, $specification->reasonCode());
    }

    public function prefixCounterProvider(): array
    {
        return [
            [8, 2 + 113],
            [12, 5 + 113],
            [13, 5 + 113],
            [14, 5 + 113],
        ];
    }

    /**
     * @dataProvider prefixCounterProvider
     */
    public function testListRanges(int $length, int $count): void
    {
        $specification = new Gtin\Specification\Prefix();

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, ['length' => $length]);

        $prefixes = $specification->listRanges($gtin);

        self::assertSame($count, count($prefixes));
    }

    public function prefixProvider(): array
    {
        return [
            [8, '101', true],
            [8, '099', false],
            [12, '035', true],
            [12, '025', false],
            [13, '118', true],
            [13, '140', false],
            [14, '950', true],
            [14, '956', false],
        ];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testIsSatisfied(int $length, string $prefix, bool $isSatisfied): void
    {
        $specification = new Gtin\Specification\Prefix();

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, [
            'length' => $length,
            'prefix' => $prefix,
        ]);

        self::assertSame($isSatisfied, $specification->isSatisfied($gtin));
    }
}
