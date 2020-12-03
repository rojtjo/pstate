<?php

declare(strict_types=1);

namespace PState;

use Traversable;

final class Collection
{
    private array $items;

    public function __construct(iterable $items)
    {
        $this->items = $this->iterableToArray($items);
    }

    /**
     * @param iterable $items
     * @return array
     */
    private function iterableToArray(iterable $items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }

    public function map(callable $callback): self
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $callback($item);
        }

        return new self($items);
    }

    public function filter(callable $callback): self
    {
        return new self(
            array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    public function reject(callable $callback): self
    {
        return $this->filter(fn (...$args) => ! $callback(...$args));
    }

    public function reverse(): self
    {
        return new self(array_reverse($this->items));
    }

    public function implode(string $separator): string
    {
        return implode($separator, $this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function dd(): void
    {
        dd($this->items);
    }
}
