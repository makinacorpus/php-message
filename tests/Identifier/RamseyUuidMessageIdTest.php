<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Tests\Identifier;

use MakinaCorpus\Message\Identifier\RamseyUuidMessageId;
use MakinaCorpus\Message\Identifier\StringMessageId;
use MakinaCorpus\Message\Identifier\SymfonyUidMessageId;
use PHPUnit\Framework\TestCase;

final class RamseyUuidMessageIdTest extends TestCase
{
    public function testEqualsWithSymfonyUid(): void
    {
        $reference = RamseyUuidMessageId::random();

        $equals = SymfonyUidMessageId::fromString($reference->toString());
        $different = SymfonyUidMessageId::random();

        self::assertTrue($reference->equals($reference));
        self::assertTrue($reference->equals($equals));
        self::assertFalse($reference->equals($different));
    }

    public function testEqualsWithString(): void
    {
        $reference = RamseyUuidMessageId::random();

        $equals = StringMessageId::fromString($reference->toString());
        $different = StringMessageId::random();

        self::assertTrue($reference->equals($reference));
        self::assertTrue($reference->equals($equals));
        self::assertFalse($reference->equals($different));
    }

    public function testEqualsWithRamseyUuid(): void
    {
        $reference = RamseyUuidMessageId::random();

        $equals = RamseyUuidMessageId::fromString($reference->toString());
        $different = RamseyUuidMessageId::random();

        self::assertTrue($reference->equals($reference));
        self::assertTrue($reference->equals($equals));
        self::assertFalse($reference->equals($different));
    }
}
