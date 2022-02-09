<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Identifier;

/**
 * Represents a message identifier.
 */
interface MessageId
{
    /**
     * Does the other identifier yield the same value.
     */
    public function equals(MessageId $other): bool;

    /**
     * Compute string value.
     */
    public function toString(): string;

    /**
     * Compute string value.
     */
    public function __toString(): string;
}
