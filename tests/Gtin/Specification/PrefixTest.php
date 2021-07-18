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

    public function prefixCounterProvider(): iterable
    {
        yield 'GTIN-8' => [8, 113 + 6];
        yield 'GTIN-12' => [12, 113 + 12];
        yield 'GTIN-13' => [13, 113 + 12];
        yield 'GTIN-14' => [14, 113 + 12];
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

    public function prefixProvider(): iterable
    {
        yield '101' => ['101', 8, true];
        yield '099' => ['099', 8, true];
        yield '035' => ['035', 12, true];
        yield '025' => ['025', 12, true];
        yield '118' => ['118', 13, true];
        yield '140' => ['140', 13, false];
        yield '950' => ['950', 14, true];
        yield '956' => ['956', 14, false];
    }

    /**
     * @dataProvider prefixProvider
     */
    public function testIsSatisfied(string $prefix, int $length, bool $isSatisfied): void
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
