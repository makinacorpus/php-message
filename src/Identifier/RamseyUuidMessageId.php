<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Identifier;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class RamseyUuidMessageId implements MessageId
{
    private UuidInterface $value;

    public function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    /**
     * Generate random identifier.
     */
    public static function fromString(string $value): self
    {
        return new self(Uuid::fromString($value));
    }

    /**
     * Generate random identifier.
     */
    public static function random(): self
    {
        return new self(Uuid::uuid4());
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MessageId $other): bool
    {
        if ($other instanceof self) {
            return $this->value->equals($other->value);
        }
        return $other->toString() === (string) $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->value->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->value->toString();
    }

    /**
     * Get internal value.
     */
    public function getValue(): UuidInterface
    {
        return $this->value;
    }
}
