<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class StateConfig
{
    /**
     * @param string $id
     * @param array<TransitionConfig>|null $on
     * @param string|null $initial
     * @param array<self>|null $states
     */
    public function __construct(
        public string $id,
        public ?array $on = null,
        public ?string $initial = null,
        public ?array $states = null,
    )
    {
    }

    /**
     * @param array $config
     * @return self
     */
    public static function fromArray(array $config): self
    {
        $transitions = [];
        foreach ($config['on'] ?? [] as $event => $target) {
            $transitions[] = new TransitionConfig($event, $target);
        }

        $states = [];
        foreach ($config['states'] ?? [] as $id => $state) {
            $states[] = self::fromArray($state + ['id' => $id]);
        }

        return new self(
            id: $config['id'],
            on: $transitions ?: null,
            initial: $config['initial'] ?? null,
            states: $states ?: null,
        );
    }
}
