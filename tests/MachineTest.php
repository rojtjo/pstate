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

    /**
     * @test
     * @dataProvider transitionDataProvider
     * @param string $expected
     * @param string $value
     * @param string $event
     */
    public function transition(string $expected, string $value, string $event): void
    {
        $machine = new Machine(Toggle::config());
        $initialState = State::fromValue($value);

        $newState = $machine->transition($initialState, $event);

        $this->assertSame($expected, $newState->value());
    }

    public function transitionDataProvider(): array
    {
        return [
            'inactive to active' => ['active', 'inactive', 'TOGGLE'],
            'active to inactive' => ['inactive', 'active', 'TOGGLE'],
        ];
    }

    /**
     * @test
     * @dataProvider transitionNestedDataProvider
     * @param string|array $expected
     * @param string|array $value
     * @param string $event
     */
    public function transition_nested(string|array $expected, string|array $value, string $event): void
    {
        $machine = new Machine(TrafficLight::config());

        $initialState = State::fromValue($value);

        $newState = $machine->transition($initialState, $event);

        $this->assertSame($expected, $newState->value());
    }

    public function transitionNestedDataProvider(): array
    {
        return [
            'transition from toplevel state to nested state' => [['red' => 'walk'], 'yellow', 'TIMER'],
            'transition from nested state to nested state' => [['red' => 'wait'], ['red' => 'walk'], 'PED_TIMER'],
            'transition from nested state to toplevel state' => ['green', ['red' => 'wait'], 'TIMER'],
        ];
    }
}
