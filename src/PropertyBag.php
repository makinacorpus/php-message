<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

/**
 * Message properties container.
 */
class PropertyBag
{
    /** array<string,null|string|int|bool|float> */
    private array $data = [];

    public function __construct(?array $properties = null)
    {
        if ($properties) {
            $this->setAll($properties);
        }
    }

    /**
     * Validate and set properties.
     */
    public function setAll(array $properties): void
    {
        foreach ($properties as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * Validate and set a single property.
     */
    public function set(string $name, mixed $value): void
    {
        if (null === $value || '' === $value) {
            unset($this->data[$name]);
        } else if (\is_scalar($value) || $value instanceof \Stringable) {
            $this->data[$name] = (string) $value;
        } else {
            throw new \InvalidArgumentException(\sprintf("Property value for key '%s' must be a string or scalar, '%s' given.", $name, \get_debug_type($value)));
        }
    }

    /**
     * Create new instance with additional properties.
     *
     * Null or empty values will remove values from the resulting object if
     * set in current object.
     *
     * @return static
     */
    public function cloneWith(array $properties = null): self
    {
        $ret = clone $this;
        $ret->setAll($properties);

        return $ret;
    }

    /**
     * Get message identifier computed from properties.
     */
    public function getMessageId(): ?string
    {
        return $this->get(Property::MESSAGE_ID);
    }

    /**
     * Get reply to value.
     */
    public function getReplyTo(): ?string
    {
        return $this->get(Property::REPLY_TO);
    }

    /**
     * Get the content encoding property.
     */
    public function getContentEncoding(): ?string
    {
        return $this->get(Property::CONTENT_ENCODING, Property::DEFAULT_CONTENT_ENCODING);
    }

    /**
     * Get the content type property.
     */
    public function getContentType(): ?string
    {
        return $this->get(Property::CONTENT_TYPE, Property::DEFAULT_CONTENT_TYPE);
    }

    /**
     * Get the subject property.
     */
    public function getSubject(): ?string
    {
        return $this->get(Property::SUBJECT);
    }

    /**
     * Get the user identifier property.
     */
    public function getUserId(): ?string
    {
        return $this->get(Property::USER_ID);
    }

    /**
     * Get property value.
     */
    public function get(string $name, ?string $default = null): ?string
    {
        return $this->data[$name] ?? $default;
    }

    /**
     * Does the given property is set.
     */
    public function has(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Get properties.
     */
    public function all(): array
    {
        return $this->data;
    }
}
