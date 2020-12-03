<?php

declare(strict_types=1);

namespace PState\Fixtures;

use PState\Machine;
use function PState\machine;

final class Toggle
{
    public const DEFINITION = [
        'id' => 'toggle',
        'initial' => 'inactive',
        'states' => [
            'inactive' => ['on' => ['TOGGLE' => 'active']],
            'active' => ['on' => ['TOGGLE' => 'inactive']],
        ],
    ];

    public static function machine(): Machine
    {
        return machine(self::DEFINITION);
    }
}
