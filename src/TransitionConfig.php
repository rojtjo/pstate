<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class TransitionConfig
{
    /**
     * @param string $event
     * @param string $target
     */
    public function __construct(
        public string $event,
        public string $target,
    )
    {
    }
}
