<?php

declare(strict_types=1);

namespace MakinaCorpus\Message\Property;

use MakinaCorpus\Message\Property;
use MakinaCorpus\Message\Identifier\MessageId;
use MakinaCorpus\Message\Identifier\MessageIdFactory;

/**
 * Helper for embedding properties into messages or enveloppes.
 *
 * @codeCoverageIgnore
 */
trait WithPropertiesTrait
{
    private array $properties = [];
    private ?MessageId $messageId = null;

    /**
     * Override properties.
     *
     * @return $this
     */
    protected function setProperties(array $properties): void
    {
        foreach ($properties as $key => $value) {
            if (Property::MESSAGE_ID === $key) {
                $this->messageId = null; // Reset message id if already computed.
            }
            if (null === $value || '' === $value) {
                unset($this->properties[$key]);
            } else if (\is_scalar($value) || $value instanceof \Stringable) {
                $this->properties[$key] = (string) $value;
            } else {
                throw new \InvalidArgumentException(\sprintf("Property value for key '%s' must be a string or scalar, '%s' given.", $key, \get_debug_type($value)));
            }
        }
    }

    /**
     * Set message identifier.
     *
     * @internal
     *   For Envelope::wrap() usage, allows a minor performance boost.
     *
     * @return $this
     */
    public function withMessageId(MessageId $messageId): self /* static */
    {
        if (null !== ($existing = $this->getProperty(Property::MESSAGE_ID))) {
            if ($existing !== $messageId->toString()) {
                throw new \InvalidArgumentException("Message identifier '%s' differs from properties values '%s'.", $messageId, $existing);
            }
        }

        $this->messageId = $messageId;

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
        return $this->properties[$name] ?? $default;
    }

    /**
     * Does the given property is set.
     */
    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * Get properties.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
