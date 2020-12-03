<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class Path
{
    private const STRING_SEPARATOR = '.';

    private function __construct(
        private array $path,
    )
    {
    }

    public static function fromString(string $path): self
    {
        return new self(
            explode(self::STRING_SEPARATOR, $path)
        );
    }

    public static function fromStateNode(?StateNode $node): self
    {
        if ($node === null) {
             return new self([]);
        }

        $ancestors = [];
        while ($node = $node->parent) {
            $ancestors[] = $node;
        }

        $path = collect($ancestors)
            ->reject(fn (StateNode $node) => $node->isMachine())
            ->map(fn (StateNode $node) => $node->id)
            ->reverse()
            ->toArray();

        return new self($path);
    }

    public static function fromRoot(): self
    {
        return new self([]);
    }

    public function append(string $append): self
    {
        return new self([
            ...$this->path,
            $append,
        ]);
    }

    public function toArray(): array
    {
        return $this->path;
    }

    public function toString(): string
    {
        return implode(self::STRING_SEPARATOR, $this->path);
    }
}
