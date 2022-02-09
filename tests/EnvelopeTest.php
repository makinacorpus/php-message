<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Tests;

use PHPUnit\Framework\TestCase;
use MakinaCorpus\Message\Envelope;
use MakinaCorpus\Message\Property;

final class EnvelopeTest extends TestCase
{
    public function testAccessor(): void
    {
        $reference = Envelope::wrap('{"foo":"bar"}', [Property::MESSAGE_ID => 'some_id']);
        self::assertSame('{"foo":"bar"}', $reference->getMessage());
    }

    public function testWrapWithInstanceKeepsMessageId(): void
    {
        $reference = Envelope::wrap('{"foo":"bar"}', [Property::MESSAGE_ID => 'some_id']);
        $tested = Envelope::wrap($reference);
        self::assertTrue($reference->getMessageId()->equals($tested->getMessageId()));
    }

    public function testWrapWithInstanceGeneratesMessageId(): void
    {
        $reference = Envelope::wrap('{"foo":"bar"}');
        $tested = Envelope::wrap($reference);
        self::assertNotEmpty($tested->getMessageId()->toString());
    }

    public function testWrapWithInstancePropagatesProperties(): void
    {
        $reference = Envelope::wrap('{"foo":"bar"}', ['x-other' => 'bla']);
        self::assertSame('bla', $reference->getProperty('x-other'));
        $tested = Envelope::wrap($reference, [Property::MESSAGE_ID => 'some_id', 'x-test' => 'bla', 'x-other' => null]);
        self::assertSame('some_id', $tested->getMessageId()->toString());
        self::assertSame('bla', $tested->getProperty('x-test'));
        self::assertNull($tested->getProperty('x-other'));
    }

    public function testWrapKeepsMessageId(): void
    {
        $tested = Envelope::wrap('{"foo":"bar"}', [Property::MESSAGE_ID => 'some_id']);
        self::assertSame('some_id', $tested->getMessageId()->toString());
    }

    public function testWrapGeneratesMessageId(): void
    {
        $tested = Envelope::wrap('{"foo":"bar"}');
        self::assertNotEmpty($tested->getMessageId()->toString());
    }

    public function testWrapPropagatesProperties(): void
    {
        $tested = Envelope::wrap('{"foo":"bar"}', [Property::MESSAGE_ID => 'some_id', 'x-test' => 'bla']);
        self::assertSame('some_id', $tested->getMessageId()->toString());
        self::assertSame('bla', $tested->getProperty('x-test'));
    }
}
