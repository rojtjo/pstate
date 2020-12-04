<?php

declare(strict_types=1);

namespace PState;

use PHPUnit\Framework\TestCase;
use PState\Fixtures\Toggle;
use PState\Fixtures\TrafficLight;

final class MachineTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function create_new_machine_from_config(): void
    {
        $config = Toggle::config();

        new Machine($config);
    }

    /** @test */
    public function transition(): void
    {
        $config = Toggle::config();

        $machine = new Machine($config);

        $this->assertSame('active', $machine->transition(State::fromValue('inactive'), 'TOGGLE')->value());
        $this->assertSame('inactive', $machine->transition(State::fromValue('active'), 'TOGGLE')->value());
    }

    /** @test */
    public function transition_nested(): void
    {
        $config = TrafficLight::config();

        $machine = new Machine($config);

        $this->assertSame(['red' => 'walk'], $machine->transition(State::fromValue('yellow'), 'TIMER')->value());
        $this->assertSame(['red' => 'wait'], $machine->transition(State::fromValue(['red' => 'walk']), 'PED_TIMER')->value());

        $this->assertSame('yellow', $machine->transition(State::fromValue('green'), 'TIMER')->value());
        $this->assertSame(['red' => 'walk'], $machine->transition(State::fromValue('yellow'), 'TIMER')->value());
        $this->assertSame(['red' => 'wait'], $machine->transition(State::fromValue(['red' => 'walk']), 'PED_TIMER')->value());
        $this->assertSame('green', $machine->transition(State::fromValue(['red' => 'wait']), 'TIMER')->value());
    }
}
