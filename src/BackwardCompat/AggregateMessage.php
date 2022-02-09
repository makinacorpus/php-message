<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\BackwardCompat;

use Ramsey\Uuid\UuidInterface;

/**
 * For messages that identifies an aggregate/entity.
 *
 * @codeCoverageIgnore
 *
 * @deprecated
 *   Your application should handle this, not this contract.
 *   We keep this for backward compability purpose.
 */
interface AggregateMessage
{
    /**
     * Get target aggregate identifier.
     */
    public function getAggregateId(): UuidInterface;

    /**
     * Get root aggregate identifier
     */
    public function getAggregateRoot(): ?UuidInterface;

    /**
     * Get target aggregate type
     */
    public function getAggregateType(): ?string;
}
