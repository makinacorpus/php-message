<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

use MakinaCorpus\Message\Identifier\MessageId;
use MakinaCorpus\Message\Identifier\MessageIdFactory;

/**
 * Message envelope which carries the message properties and data.
 *
 * This implementation will always attempt to generate a message identifier
 * if none was provided by the application layer. It will always be a UUID4
 * identifier.
 */
class Envelope
{
    private ?PropertyBag $properties = null;
    private ?MessageId $messageId = null;
    private mixed $message;

    /**
     * Please use the Envelope::wrap() method.
     */
    protected function __construct(mixed $message, array $properties = [])
    {
        $this->message = $message;
        $this->setProperties($properties);
    }

    /**
     * Create instance from message.
     *
     * @return static
     */
    public static function wrap(mixed $message, array $properties = []): Envelope /* @todo static */
    {
        if ($message instanceof static) {
            $message->setProperties($properties);

            return $message;
        }

        return new static($message, $properties);
    }

    /**
     * Get internal message.
     */
    public function getMessage(): mixed
    {
        return $this->message;
    }

    /**
     * Get internal property bag.
     */
    public function getPropertyBag(): PropertyBag
    {
        return $this->properties ?? ($this->properties = new PropertyBag());
    }

    /**
     * Override properties.
     *
     * @return $this
     *
     * @deprecated
     *   Use setProperties() instead.
     */
    public function withProperties(array $properties): Envelope /* @todo static */
    {
        @\trigger_error(\sprintf("Please use %s::setProperties() instead.", E_USER_DEPRECATED));

        $this->setProperties($properties);

        return $this;
    }

    /**
     * Override properties, dealing with message identifier along the way.
     *
     * @return $this
     */
    public function setProperties(array $properties): void
    {
        $propertyBag = $this->getPropertyBag();

        if ($messageId = ($properties[Property::MESSAGE_ID] ?? null)) {
            unset($properties[Property::MESSAGE_ID]);
            $this->setMessageId(MessageIdFactory::create($messageId));
        } else if (!$propertyBag->has(Property::MESSAGE_ID)) {
            $this->setMessageId(MessageIdFactory::generate());
        }

        $propertyBag->setAll($properties);
    }

    /**
     * @deprecated
     *   Use self::setMessageId()
     *
     * @return $this
     */
    public function withMessageId(MessageId $messageId): self /* static */
    {
        $this->setMessageId($messageId);

        return $this;
    }

    /**
     * Set message identifier.
     *
     * @internal
     *   For Envelope::wrap() usage, allows a minor performance boost.
     *
     * @return $this
     */
    public function setMessageId(MessageId $messageId): self /* static */
    {
        $this->messageId = $messageId;
        $this->properties->set(Property::MESSAGE_ID, $messageId->toString());

        return $this;
    }

    /**
     * Get message identifier computed from properties.
     */
    public function getMessageId(): ?MessageId
    {
        if ($this->messageId) {
            return $this->messageId;
        }
        if (null !== ($rawMessageId = $this->getProperty(Property::MESSAGE_ID))) {
            return $this->messageId = MessageIdFactory::create($rawMessageId);
        }
        return null;
    }

    /**
     * Get the content encoding property.
     */
    public function getMessageContentEncoding(): ?string
    {
        return $this->getProperty(Property::CONTENT_ENCODING) ?? Property::DEFAULT_CONTENT_ENCODING;
    }

    /**
     * Get the content type property.
     */
    public function getMessageContentType(): ?string
    {
        return $this->getProperty(Property::CONTENT_TYPE) ?? Property::DEFAULT_CONTENT_TYPE;
    }

    /**
     * Get the subject property.
     */
    public function getMessageSubject(): ?string
    {
        return $this->getProperty(Property::SUBJECT);
    }

    /**
     * Get the user identifier property.
     */
    public function getMessageUserId(): ?string
    {
        return $this->getProperty(Property::USER_ID);
    }

    /**
     * Get property value.
     */
    public function getProperty(string $name, ?string $default = null): ?string
    {
        return $this->getPropertyBag()->get($name, $default);
    }

    /**
     * Does the given property is set.
     */
    public function hasProperty(string $name): bool
    {
        return $this->getPropertyBag()->has($name);
    }

    /**
     * Get properties.
     */
    public function getProperties(): array
    {
        return $this->getPropertyBag()->all();
    }
}
