<?php

declare(strict_types=1);

namespace PState;

use PHPUnit\Framework\TestCase;
use PState\Fixtures\Toggle;
use PState\Fixtures\TrafficLight;

final class MachineTest extends TestCase
{
    /** @test */
    public function simple(): void
    {
        $toggleMachine = machine(Toggle::DEFINITION);

        $this->assertSame('active', $toggleMachine->transition('inactive', 'TOGGLE'));
        $this->assertSame('inactive', $toggleMachine->transition('active', 'TOGGLE'));
    }

    /** @test */
    public function nested(): void
    {
        $lightMachine = machine(TrafficLight::DEFINITION);

        $this->assertSame('yellow', $lightMachine->transition('green', 'TIMER'));
        $this->assertSame('red.walk', $lightMachine->transition('yellow', 'TIMER'));
        $this->assertSame('red.wait', $lightMachine->transition('red.walk', 'PED_TIMER'));
        $this->assertSame('green', $lightMachine->transition('red.wait', 'TIMER'));
    }
}
