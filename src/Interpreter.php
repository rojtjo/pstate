<?php

declare(strict_types=1);

namespace PState;

final class Interpreter
{
    /**
     * @var string|null
     * @psalm-readonly-allow-private-mutation
     */
    public ?string $value;

    public function __construct(
        private Machine $machine
    )
    {
        $this->value = null;
    }

    public function start(): self
    {
        $this->value = $this->machine->initial;

        return $this;
    }

    public function send(string $event): self
    {
        if ( ! $this->value) {
            throw new \RuntimeException('Interpreter not started');
        }

        $this->value = $this->machine->transition($this->value, $event);

        return $this;
    }
}
