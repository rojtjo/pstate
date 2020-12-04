<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class StateNode
{
    /**
     * @var Path
     */
    public Path $key;

    /**
     * @var Machine
     */
    public Machine $machine;

    /**
     * @var self|null
     */
    public ?self $parent;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var string|null
     */
    public ?string $initial;

    /**
     * @var array<string, StateNode>|null
     */
    public ?array $states;

    /**
     * @var array<string, Transition>|null
     */
    public ?array $on;

    /**
     * @param StateConfig $config
     * @param Machine $machine
     * @param StateNode|null $parent
     */
    public function __construct(StateConfig $config, Machine $machine, ?self $parent = null)
    {
        $this->parent = $parent;
        $this->machine = $machine;
        $this->id = $config->id;
        $this->initial = $config->initial;
        $this->on = $config->on;
        $this->key = $parent?->key->concat($this->id) ?? Path::fromString($this->id);

        $transitions = [];
        if ($config->on) {
            $transitions = [];
            foreach ($config->on as $transition) {
                $transitions[$transition->event] = new Transition($transition, $this->parent?->key);
            }
        }

        $this->on = $transitions ?: null;

        $states = [];
        if ($config->states) {
            $states = [];
            foreach ($config->states as $state) {
                $states[$state->id] = new StateNode($state, $machine, $this);
            }
        }

        $this->states = $states ?: null;
    }

    /**
     * @param string $event
     * @return State
     */
    public function on(string $event): State
    {
        $transition = $this->transition($event);

        $nextState = $this->machine->state($transition->target);
        if ($nextState->isLeaf()) {
            return State::fromValue($transition->target->toValue());
        }

        $target = $nextState->key->concat($nextState->initial);

        return State::fromValue($target->toValue());
    }

    /**
     * @return bool
     */
    public function isLeaf(): bool
    {
        return $this->initial === null || $this->states === null;
    }

    private function transition(string $event): ?Transition
    {
        foreach ($this->on as $transition) {
            if ($transition->event === $event) {
                return $transition;
            }
        }

        return $this->parent?->transition($event);
    }
}
