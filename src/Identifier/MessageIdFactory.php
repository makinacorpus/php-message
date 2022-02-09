<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Identifier;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Uid\AbstractUid;

/**
 * Static configurable identifier factory that will use the environment
 * available library.
 *
 * @todo Make this extensible.
 */
class MessageIdFactory
{
    const RAMSEY_UUID = 1;
    const SYMFONY_UID = 2;
    const TOTALLY_STUPID_IMPLEMENTATION = 0;

    public static function setPreferedImplementation(int $preferedImplementation): void
    {
        self::$preferedImplementation = $preferedImplementation;
    }

    /**
     * Current prefered implementation.
     */
    private static ?int $preferedImplementation = null;

    /**
     * Compute prefered implementation.
     *
     * @codeCoverageIgnore
     */
    private static function getPreferedImplementation(): int
    {
        if (null !== self::$preferedImplementation) {
            return self::$preferedImplementation;
        }

        if (\interface_exists(UuidInterface::class)) {
            self::$preferedImplementation = self::RAMSEY_UUID;
        } else if (\class_exists(AbstractUid::class)) {
            self::$preferedImplementation = self::SYMFONY_UID;
        } else {
            \trigger_error("This library strongly advises that you choose between and install one of ramsey/uuid or symfony/ulid for handling message identifiers.", E_USER_WARNING);
            self::$preferedImplementation = self::TOTALLY_STUPID_IMPLEMENTATION;
        }

        return self::$preferedImplementation;
    }

    /**
     * Generate supposedly universally unique message identifier.
     */
    public static function generate(): MessageId
    {
        switch (self::getPreferedImplementation()) {

            case self::RAMSEY_UUID:
                return RamseyUuidMessageId::random();

            case self::SYMFONY_UID:
                return SymfonyUidMessageId::random();

            default:
                return StringMessageId::random();
        }
    }

    /**
     * Create message identifier from value.
     */
    public static function create(mixed $value): MessageId
    {
        if (null === $value) {
            throw new \InvalidArgumentException("Cannot create null message identifier.");
        }
        if ($value instanceof MessageId) {
            return $value;
        }
        if ($value instanceof UuidInterface) {
            return new RamseyUuidMessageId($value);
        }
        if ($value instanceof AbstractUid) {
            return new SymfonyUidMessageId($value);
        }
        if (\is_string($value) || $value instanceof \Stringable || \is_numeric($value)) {
            return new StringMessageId((string) $value);
        }
        throw new \InvalidArgumentException(\sprintf("Unsupported message identifier value type '%s'.", \get_debug_type($value)));
    }
}
