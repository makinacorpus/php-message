<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Identifier;

use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

final class SymfonyUidMessageId implements MessageId
{
    private AbstractUid $value;

    public function __construct(AbstractUid $value)
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
        return new self(Uuid::v4());
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
        return (string) $this->value;
    }

    /**
     * Get internal value.
     */
    public function getValue(): AbstractUid
    {
        return $this->value;
    }
}
