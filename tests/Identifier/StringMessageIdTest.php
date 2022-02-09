<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Tests\Identifier;

use MakinaCorpus\Message\Identifier\StringMessageId;
use MakinaCorpus\Message\Identifier\SymfonyUidMessageId;
use PHPUnit\Framework\TestCase;

final class StringMessageIdTest extends TestCase
{
    public function testEqualsWithString(): void
    {
        $reference = SymfonyUidMessageId::random();

        $equals = StringMessageId::fromString($reference->toString());
        $different = StringMessageId::random();

        self::assertTrue($reference->equals($reference));
        self::assertTrue($reference->equals($equals));
        self::assertFalse($reference->equals($different));
    }

    public function testDisallowsEmptyString(): void
    {
        self::expectException(\InvalidArgumentException::class);
        new StringMessageId('');
    }
}
