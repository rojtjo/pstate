<?php

declare(strict_types=1);

namespace PState\Fixtures;

use PState\Machine;
use function PState\machine;

final class TrafficLight
{
    private const PEDESTRIAN_STATES = [
    ];

    public const DEFINITION = [
        'id' => 'light',
        'initial' => 'green',
        'states' => [
            'green' => [
                'on' => [
                    'TIMER' => 'yellow',
                ],
            ],
            'yellow' => [
                'on' => [
                    'TIMER' => 'red',
                ],
            ],
            'red' => [
                'on' => [
                    'TIMER' => 'green',
                ],
                'initial' => 'walk',
                'states' => [
                    'walk' => [
                        'on' => [
                            'PED_TIMER' => 'wait',
                        ],
                    ],
                    'wait' => [
                        'on' => [
                            'PED_TIMER' => 'stop',
                        ],
                    ],
                    'stop' => [],
                ],
            ],
        ],
    ];

    public static function machine(): Machine
    {
        return machine(self::DEFINITION);
    }
}
