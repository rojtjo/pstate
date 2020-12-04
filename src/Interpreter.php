<?php

declare(strict_types=1);

namespace PState;

final class Interpreter
{
    private ?State $state;

    public function __construct(
        private Machine $machine
    )
    {
    }

    public function start(): self
    {
        $this->state = $this->machine->initial();

        return $this;
    }

    public function send(string $event): self
    {
        if ( ! $this->state) {
            throw new \RuntimeException('Interpreter not started');
        }

        $this->state = $this->machine->transition($this->state, $event);

        return $this;
    }

    public function state(): State
    {
        if ( ! $this->state) {
            throw new \RuntimeException('Interpreter not started');
        }

        return $this->state;
    }

    public function stateValue(): string|array
    {
        return $this->state()->value();
    }
}
