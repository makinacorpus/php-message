<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

/**
 * If you wish to be error tolerant in your deserialization layer, use this
 * class to wrap your serialization failures.
 */
final class BrokenEnvelope extends Envelope
{
}
