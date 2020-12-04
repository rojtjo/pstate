<?php

declare(strict_types=1);

namespace PState;

use PHPUnit\Framework\TestCase;

final class StateValueTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function construct_with_string_value(): void
    {
        new StateValue('active');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function construct_with_nested_value(): void
    {
        new StateValue(['red' => 'walk']);
    }

    /** @test */
    public function paths_with_string_value(): void
    {
        $stateValue = new StateValue('active');

        $paths = $stateValue->paths();

        $this->assertCount(1, $paths);

        $this->assertEquals(Path::fromString('active'), $paths[0]);
    }

    /** @test */
    public function paths_with_nested_value(): void
    {
        $stateValue = new StateValue(['red' => 'walk']);

        $paths = $stateValue->paths();

        $this->assertCount(1, $paths);

        $this->assertEquals(Path::fromString('red.walk'), $paths[0]);
    }

    /** @test */
    public function paths_with_parallel_value(): void
    {
        $stateValue = new StateValue(['bold' => 'off', 'underline' => 'on', 'italics' => 'off', 'list' => 'none']);

        $paths = $stateValue->paths();

        $this->assertCount(4, $paths);

        $this->assertEquals(Path::fromString('bold.off'), $paths[0]);
        $this->assertEquals(Path::fromString('underline.on'), $paths[1]);
        $this->assertEquals(Path::fromString('italics.off'), $paths[2]);
        $this->assertEquals(Path::fromString('list.none'), $paths[3]);
    }
}
