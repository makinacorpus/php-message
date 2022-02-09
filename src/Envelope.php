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
     * Please use the Envelope::wrap() method instead.
     */
    private function __construct()
    {
    }

    /**
     * Create instance from message.
     *
     * @return static
     */
    public static function wrap(mixed $message, array $properties = []): Envelope /* @todo static */
    {
        if ($message instanceof static) {
            $ret = $message->withProperties($properties);
        } else {
            $ret = new static();
            $ret->message = $message;
            $ret->withProperties($properties);
        }
        if (!$ret->hasProperty(Property::MESSAGE_ID)) {
            return $ret->withMessageId(MessageIdFactory::generate());
        }
        return $ret;
    }

    /**
     * Override properties.
     *
     * @return $this
     */
    public function withProperties(array $properties): Envelope /* @todo static */
    {
        foreach ($properties as $key => $value) {
            if (Property::MESSAGE_ID === $key) {
                $this->messageId = null; // Reset message id if already computed.
            }
            if (null === $value || '' === $value) {
                unset($this->properties[$key]);
            } else {
                $this->properties[$key] = (string)$value;
            }
        }

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
