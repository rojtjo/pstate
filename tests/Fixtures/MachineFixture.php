<?php

declare(strict_types=1);

namespace PState\Fixtures;

use PState\Machine;
use PState\MachineConfig;
use function PState\machine;

abstract class MachineFixture
{
    public static function machine(): Machine
    {
        return machine(static::definition());
    }

    public static function config(): MachineConfig
    {
        return MachineConfig::fromArray(static::definition());
    }

    abstract public static function definition(): array;
}
