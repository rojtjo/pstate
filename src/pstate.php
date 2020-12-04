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
    $config = MachineConfig::fromArray($machine);
    return new Machine($config);
}
