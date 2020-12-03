<?php

declare(strict_types=1);

namespace PState;

/** @psalm-immutable */
class StateNode
{
    /** @var string */
    public string $id;
    /** @var string|null */
    public ?string $initial = null;
    /** @var array<string, self>|null */
    public ?array $states = null;
    /** @var array<string, string>|null */
    public ?array $on = null;
    /** @var StateNode|null */
    public ?StateNode $parent = null;

    /**
     *
     */
    public function __construct(string $id, ?string $initial = null, ?array $states = null, ?array $on = null, ?self $parent = null)
    {
        $this->id = $id;
        $this->initial = $initial;
        $this->states = $states ? create_states($states, $this) : null;
        $this->on = $on;
        $this->parent = $parent;
    }

    public function isMachine(): bool
    {
        return $this instanceof Machine;
    }

    public function isLeaf(): bool
    {
        return $this->initial === null && $this->states === null;
    }

    public function isComplex(): bool
    {
        return ! $this->isLeaf()
            && ! $this->isMachine();
    }

    protected function transitions(): array
    {
        return array_merge(
            $this->on ?? [],
            $this->parent?->on ?? [],
        );
    }

    public function path(): array
    {
    }
}
