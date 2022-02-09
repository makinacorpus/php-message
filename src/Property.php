<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

use MakinaCorpus\Message\Property\PropertyAmqp1_0;

/**
 * Define a common list of well known message properties that can match and
 * be found in many command or event bus implementations.
 *
 * This list is mostly opiniated because it was extracted from an existing
 * custom event store and command dispatcher implementions.
 *
 * Most are AMQP 1.0 compatible, we arbitrarily added a "type" property
 * for payload to PHP class content conversion, to hint serializers.
 *
 * All x-* properties are inherited from custom projects, kept for backward
 * compatibility. You may or may not use those, they will remain stable in
 * time. "goat" name refers to the unstable state of those projects at the
 * time and are kept as-is in order to be able to distinguish the legacy
 * property names from stable ones.
 *
 * @codeCoverageIgnore
 */
final class Property extends PropertyAmqp1_0
{
    const DEFAULT_TYPE = 'none';
    const DEFAULT_NAMESPACE = 'default';
    const DEFAULT_CONTENT_TYPE = 'application/json';
    const DEFAULT_CONTENT_ENCODING = 'UTF-8';

    const DELIVERY_MODE_TRANSCIENT = 1;
    const DELIVERY_MODE_PERSISTENT = 2;

    /** From Rabbitmq own AMQP 0.9 interpretation. */
    const APP_ID = 'app-id';
    /** From Rabbitmq own AMQP 0.9 interpretation. */
    const MESSAGE_TYPE = 'type';

    /** From AMQP 0.9, value can be either 2 (persistent) or any other value usually 1 (transcient). */
    const DELIVERY_MODE = 'delivery-mode';
    /** From AMQP 0.9 */
    const EXPIRATION = 'expiration';

    /** Current number of retry count. */
    const RETRY_COUNT = 'x-retry-count';
    /** Retry after at least <VALUE> milliseconds. */
    const RETRY_DELAI = 'x-retry-delai';
    /** Maximum number of retries (AMQP would use a TTL instead). */
    const RETRY_MAX = 'x-retry-max';
    /** Set this with any value to forbid retry. */
    const RETRY_KILLSWITCH = 'x-retry-killswitch';
    /** Why should it retry? */
    const RETRY_REASON = 'x-retry-reason';

    /** Custom header for storing event processing duration (profiling). */
    const PROCESS_DURATION = 'x-goat-duration';

    /** Event was modified, this contains arbitrary text. */
    const MODIFIED_BY = 'x-goat-modified-by';
    /** Event was modified, an ISO8601 is welcome in this value. */
    const MODIFIED_AT = 'x-goat-modified-at';
    /** Event was modified, just arbitrary text here. */
    const MODIFIED_WHY = 'x-goat-modified-why';
    /** Event was modified, previous name it had. */
    const MODIFIED_PREVIOUS_NAME = 'x-goat-modified-prev-name';
    /** Event was modified, previous revision it was at. */
    const MODIFIED_PREVIOUS_REVISION = 'x-goat-modified-prev-rev';
    /** Event was modified, an ISO8601 previous valid date. */
    const MODIFIED_PREVIOUS_VALID_AT = 'x-goat-modified-prev-valid-at';
    /** Event was modified, an ISO8601 previous valid date. */
    const MODIFIED_INSERTED = 'x-goat-modified-inserted';
}
