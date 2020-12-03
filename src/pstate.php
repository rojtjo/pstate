<?php

declare(strict_types=1);

namespace PState;

/**
 * @param Machine $machine
 * @return Interpreter
 */
function interpret(Machine $machine): Interpreter
{
    return new Interpreter($machine);
}

/**
 * @param array $machine
 * @return Machine
 */
function machine(array $machine): Machine
{
    return new Machine(
        id: $machine['id'],
        initial: $machine['initial'],
        states: $machine['states'],
    );
}

/**
 * @param array $states
 * @param StateNode $parent
 * @return array
 * @internal
 */
function create_states(array $states, StateNode $parent): array
{
    $result = [];
    foreach ($states as $id => $state) {
        $result[$id] = new StateNode(
            id: $id,
            initial: $state['initial'] ?? null,
            states: $state['states'] ?? null,
            on: $state['on'] ?? null,
            parent: $parent,

        );
    }

    return $result;
}

/**
 * @param iterable $items
 * @return Collection
 */
function collect(iterable $items): Collection
{
    return new Collection($items);
}
