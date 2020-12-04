<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class MachineConfig
{
    /**
     * @param string $id
     * @param string $initial
     * @param array<string, StateConfig> $states
     */
    public function __construct(
        public string $id,
        public string $initial,
        public array $states,
    )
    {
    }

    /**
     * @param array $config
     * @return self
     */
    public static function fromArray(array $config): self
    {
        return new self(
            id: $config['id'],
            initial: $config['initial'],
            states: array_map(function (array $state, string $id) {
                return StateConfig::fromArray($state + ['id' => $id]);
            }, $config['states'], array_keys($config['states'])),
        );
    }
}
