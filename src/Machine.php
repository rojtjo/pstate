<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class Machine
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $initial;

    /**
     * @var array<string, StateNode>
     */
    private array $states;

    /**
     * @param MachineConfig $config
     */
    public function __construct(MachineConfig $config)
    {
        $this->id = $config->id;
        $this->initial = $config->initial;

        $this->states = [];
        foreach ($config->states as $state) {
            $this->states[$state->id] = new StateNode($state, $this);
        }
    }

    /**
     * @param State $state
     * @param string $event
     * @return State
     */
    public function transition(State $state, string $event): State
    {
        foreach ($state->paths() as $path) {
            $currentState = $this->state($path);

            return $currentState->on($event);
        }
    }

    /**
     * @param Path $path
     * @return StateNode
     */
    public function state(Path $path): StateNode
    {
        $currentState = null;
        $states = $this->states;
        foreach ($path->toArray() as $part) {
            $currentState = $states[$part];
            $states = $currentState->states;
        }

        return $currentState;
    }

    public function initial(): State
    {
        return State::fromValue($this->initial);
    }
}
