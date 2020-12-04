<?php

declare(strict_types=1);

namespace PState\Fixtures;

final class Toggle extends MachineFixture
{
    public static function definition(): array
    {
        return [
            'id' => 'toggle',
            'initial' => 'inactive',
            'states' => [
                'inactive' => ['on' => ['TOGGLE' => 'active']],
                'active' => ['on' => ['TOGGLE' => 'inactive']],
            ],
        ];
    }
}
