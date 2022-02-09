<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Identifier;

/**
 * Uses arbitrary strings as message identifiers.
 *
 * From a consuming API perspective, this is legitimate since message
 * identifiers are required to be universally unique, but that being
 * the only constraint, formalism isn't important for users.
 */
final class StringMessageId implements MessageId
{
    private string $value;

    public function __construct(string $value)
    {
        if ('' === $value) {
            throw new \InvalidArgumentException("Cannot create an empty message identifier.");
        }
        $this->value = $value;
    }

    /**
     * Generate random identifier.
     */
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    /**
     * Generate random identifier.
     */
    public static function random(): self
    {
        return new self(\base64_encode((new \DateTimeImmutable())->format('YmdHisu') . '-' . \random_bytes(8)));
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MessageId $other): bool
    {
        return $other->toString() === $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->value;
    }
}
