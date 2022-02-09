<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

/**
 * Message that can provide a description for logs, user interface, ...
 */
interface DescribeableMessage
{
    /**
     * Describe the message.
     *
     * Returns an intermediate text representation with Description class
     * which allows displaying code to proceed to variable replacement if
     * necessary. For exemple, it may allow to replace a user identifier
     * with the user full name.
     *
     * How and when replacement will be done is up to each project. Provided
     * implementation simply uses a variable replacement mecanism that uses
     * the monolog formalism, using [variables].
     *
     * @code
     * <?php
     *
     * namespace App\Domain\Message;
     *
     * use MakinaCorpus\Message\DiscreableMessage
     * use MakinaCorpus\Message\Description
     *
     * final class FooEvent implements DiscreableMessage
     * {
     *     public function __construct(private string $userId): self
     *     {
     *     }
     *
     *     public function describe(): Description
     *     {
     *         return new EventDescription(
     *             "[user] said "Foo".",
     *             [
     *                  "[user]" => $this->userId,
     *             ]
     *         );
     *     }
     * }
     * @endcode
     */
    public function describe(): Description;
}
