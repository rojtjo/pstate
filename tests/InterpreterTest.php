<?php

declare(strict_types=1);

namespace PState;

use PHPUnit\Framework\TestCase;
use PState\Fixtures\Toggle;
use PState\Fixtures\TrafficLight;

final class InterpreterTest extends TestCase
{
    /** @test */
    public function simple(): void
    {
        $toggleService = interpret(Toggle::machine())->start();

        $this->assertSame('active', $toggleService->send('TOGGLE')->stateValue());
        $this->assertSame('inactive', $toggleService->send('TOGGLE')->stateValue());
    }

    /** @test */
    public function nested(): void
    {
        $lightService = interpret(TrafficLight::machine())->start();

        $this->assertSame('yellow', $lightService->send('TIMER')->stateValue());
        $this->assertSame(['red' => 'walk'], $lightService->send('TIMER')->stateValue());
        $this->assertSame(['red' => 'wait'], $lightService->send('PED_TIMER')->stateValue());
        $this->assertSame('green', $lightService->send('TIMER')->stateValue());
    }
}
