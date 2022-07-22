<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

use MakinaCorpus\Message\Identifier\MessageIdFactory;
use MakinaCorpus\Message\Property\WithPropertiesTrait;

/**
 * Message envelope which carries the message properties and data.
 *
 * This implementation will always attempt to generate a message identifier
 * if none was provided by the application layer. It will always be a UUID4
 * identifier.
 */
class Envelope
{
    use WithPropertiesTrait;

    private mixed $message;

    /**
     * Please use the Envelope::wrap() method.
     */
    protected function __construct(mixed $message, array $properties = [])
    {
        $this->message = $message;
        $this->withProperties($properties);

        if (!$this->hasProperty(Property::MESSAGE_ID)) {
            $this->messageId = $this->properties[Property::MESSAGE_ID] = MessageIdFactory::generate();
        }
    }

    /**
     * Create instance from message.
     *
     * @return static
     */
    public static function wrap(mixed $message, array $properties = []): Envelope /* @todo static */
    {
        if ($message instanceof static) {
            return $message->withProperties($properties);
        }
        return new static($message, $properties);
    }

    /**
     * Override properties.
     *
     * @return $this
     */
    public function withProperties(array $properties): Envelope /* @todo static */
    {
        $this->setProperties($properties);

        return $this;
    }

    /**
     * Get internal message.
     */
    public function getMessage(): mixed
    {
        return $this->message;
    }
}
