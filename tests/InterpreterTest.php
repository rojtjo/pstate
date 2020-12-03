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
        $toggleMachine = machine(Toggle::DEFINITION);
        $toggleService = interpret($toggleMachine)->start();

        $this->assertSame('active', $toggleService->send('TOGGLE')->value);
        $this->assertSame('inactive', $toggleService->send('TOGGLE')->value);
    }

    /** @test */
    public function nested(): void
    {
        $lightMachine = machine(TrafficLight::DEFINITION);
        $lightService = interpret($lightMachine)->start();

        $this->assertSame('yellow', $lightService->send('TIMER')->value);
        $this->assertSame('red.walk', $lightService->send('TIMER')->value);
        $this->assertSame('red.wait', $lightService->send('PED_TIMER')->value);
        $this->assertSame('green', $lightService->send('TIMER')->value);
    }
}
{
}
