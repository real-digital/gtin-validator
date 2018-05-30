<?php
declare(strict_types=1);

namespace Real\Validator\Tests\Gtin;

use PHPUnit\Framework\TestCase;
use Real\Validator\Gtin;
use Real\Validator\UserError;

class NonNormalizableTest extends TestCase
{
    public function valueProvider(): array
    {
        return [
            ['42'],
            ["\n"],
            [''],
        ];
    }

    /**
     * @dataProvider valueProvider
     */
    public function testValue(string $value)
    {
        /** @var Gtin\Specification $specification */
        $specification = $this->createMock(Gtin\Specification::class);

        $exception = new Gtin\NonNormalizable($value, $specification);

        self::assertSame($value, $exception->value());
    }

    public function testInheritance()
    {
        /** @var Gtin\Specification $specification */
        $specification = $this->createMock(Gtin\Specification::class);

        $exception = new Gtin\NonNormalizable('string', $specification);
        self::assertInstanceOf(\InvalidArgumentException::class, $exception);
        self::assertInstanceOf(UserError::class, $exception);
    }

    public function testConstantValues()
    {
        self::assertSame(1000, Gtin\NonNormalizable::CODE_LENGTH_14);
        self::assertSame(1001, Gtin\NonNormalizable::CODE_LENGTH_8);
        self::assertSame(1002, Gtin\NonNormalizable::CODE_LENGTH_KEY);
        self::assertSame(1003, Gtin\NonNormalizable::CODE_DIGITS);
        self::assertSame(1004, Gtin\NonNormalizable::CODE_CHECKSUM);
        self::assertSame(1005, Gtin\NonNormalizable::CODE_PREFIX);
    }

    public function testMessageKey()
    {
        /** @var Gtin\Specification $specification */
        $specification = $this->createConfiguredMock(Gtin\Specification::class, ['reasonCode' => 42]);
        $exception = new Gtin\NonNormalizable('123456789', $specification);

        self::assertRegExp('/%gtin%/', $exception->messageKey());
    }

    public function testMessageData()
    {
        /** @var Gtin\Specification $specification */
        $specification = $this->createConfiguredMock(Gtin\Specification::class, ['reasonCode' => 42]);
        $exception = new Gtin\NonNormalizable('123456789', $specification);

        $messageData = $exception->messageData();
        self::assertArrayHasKey('%gtin%', $messageData);
        self::assertSame('123456789', $messageData['%gtin%']);
    }
}
