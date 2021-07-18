<?php

declare(strict_types=1);

namespace Real\Validator\Tests\Gtin\Specification;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;

class CheckSumTest extends TestCase
{
    public function testSpecificationInterfaceIsInherited(): void
    {
        $specification = new Gtin\Specification\CheckSum();

        self::assertInstanceOf(Gtin\Specification::class, $specification);
    }

    public function testReasonCode(): void
    {
        $specification = new Gtin\Specification\CheckSum();

        self::assertSame(1004, $specification->reasonCode());
    }

    public function validChecksumProvider(): iterable
    {
        yield '00000096385074' => ['00000096385074', 4, true];
        yield '00614141999996' => ['00614141999996', 6, true];
        yield '04006381333931' => ['04006381333931', 1, true];
        yield '10012345678902' => ['10012345678902', 2, true];
        yield '00000073127727' => ['00000073127727', 8, false];
        yield '00942217200524' => ['00942217200524', 5, false];
        yield '05010019637666' => ['05010019637666', 7, false];
        yield '58937437933236' => ['58937437933236', 7, false];
    }

    /**
     * @dataProvider validChecksumProvider
     */
    public function testIsSatisfied(string $value, int $checkDigit, bool $isSatisfied): void
    {
        $specification = new Gtin\Specification\CheckSum();

        /** @var Gtin $gtin */
        $gtin = $this->createConfiguredMock(Gtin::class, [
            'padded' => $value,
            'checkDigit' => $checkDigit,
        ]);

        self::assertSame($isSatisfied, $specification->isSatisfied($gtin));
    }
}
