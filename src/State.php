<?php

declare(strict_types=1);

namespace PState;

/** @psalm-immutable */
final class State
{
    public function __construct(
        public string $value,
        public array $history,
    )
    {
    }
}
