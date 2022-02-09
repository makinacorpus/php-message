<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Tests;

use PHPUnit\Framework\TestCase;
use MakinaCorpus\Message\Description;

final class DescriptionTest extends TestCase
{
    public function testAccessors(): void
    {
        $desc = new Description("Coucou", ['foo']);
        self::assertSame('Coucou', $desc->getText());
        self::assertSame(['foo'], $desc->getVariables());
    }

    public function testFormatWithoutVariables(): void
    {
        $desc = new Description("Coucou");
        self::assertSame("Coucou", (string) $desc);
    }

    public function testFormat(): void
    {
        $desc = new Description("Coucou [name]", ['[name]' => "John"]);
        self::assertSame("Coucou John", (string) $desc);
    }

    public function testFormatWithoutVariableEnclosing(): void
    {
        $desc = new Description("Coucou [name]", ['name' => "John"]);
        self::assertSame("Coucou John", (string) $desc);
    }

    public function testFormatWithLegacyEnclosing(): void
    {
        $desc = new Description("Coucou [name] %lastname%", ['name' => "John", '%lastname%' => "Doe"]);
        self::assertSame("Coucou John Doe", (string) $desc);
    }
}
