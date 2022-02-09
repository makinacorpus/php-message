<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Tests\Identifier;

use MakinaCorpus\Message\Identifier\MessageIdFactory;
use MakinaCorpus\Message\Identifier\RamseyUuidMessageId;
use MakinaCorpus\Message\Identifier\StringMessageId;
use MakinaCorpus\Message\Identifier\SymfonyUidMessageId;
use PHPUnit\Framework\TestCase;

final class MessageIdFactoryTest extends TestCase
{
    public function testWithRamseyUuid(): void
    {
        MessageIdFactory::setPreferedImplementation(MessageIdFactory::RAMSEY_UUID);

        $random = MessageIdFactory::generate();
        self::assertInstanceOf(RamseyUuidMessageId::class, $random);

        $other = MessageIdFactory::generate();
        self::assertInstanceOf(RamseyUuidMessageId::class, $other);
        self::assertFalse($random->equals($other));

        $same = MessageIdFactory::create($random);
        self::assertSame($random, $same);

        $equals = MessageIdFactory::create($random->getValue());
        self::assertInstanceOf(RamseyUuidMessageId::class, $equals);
        self::assertTrue($random->equals($equals));
    }

    public function testWithSymfonyUid(): void
    {
        MessageIdFactory::setPreferedImplementation(MessageIdFactory::SYMFONY_UID);

        $random = MessageIdFactory::generate();
        self::assertInstanceOf(SymfonyUidMessageId::class, $random);

        $other = MessageIdFactory::generate();
        self::assertInstanceOf(SymfonyUidMessageId::class, $other);
        self::assertFalse($random->equals($other));

        $same = MessageIdFactory::create($random);
        self::assertSame($random, $same);

        $equals = MessageIdFactory::create($random->getValue());
        self::assertInstanceOf(SymfonyUidMessageId::class, $equals);
        self::assertTrue($random->equals($equals));
    }

    public function testWithString(): void
    {
        MessageIdFactory::setPreferedImplementation(MessageIdFactory::TOTALLY_STUPID_IMPLEMENTATION);

        $random = MessageIdFactory::generate();
        self::assertInstanceOf(StringMessageId::class, $random);

        $other = MessageIdFactory::generate();
        self::assertInstanceOf(StringMessageId::class, $other);
        self::assertFalse($random->equals($other));

        $same = MessageIdFactory::create($random);
        self::assertSame($random, $same);

        $equals = MessageIdFactory::create($random->toString());
        self::assertInstanceOf(StringMessageId::class, $equals);
        self::assertTrue($random->equals($equals));
    }

    public function testCanCreateInstanceFromStringableObject(): void
    {
        $instance = new class () {
            public function __toString(): string
            {
                return 'foo';
            }
        };

        $value = MessageIdFactory::create($instance);
        self::assertInstanceOf(StringMessageId::class, $value);
        self::assertSame('foo', $value->toString());
    }

    public function testCannotCreateInstanceFromNull(): void
    {
        self::expectException(\InvalidArgumentException::class);
        MessageIdFactory::create(null);
    }

    public function testCannotCreateInstanceFromUnsupportedValue(): void
    {
        self::expectException(\InvalidArgumentException::class);
        MessageIdFactory::create(new \DateTime());
    }
}
