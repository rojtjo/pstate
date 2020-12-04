<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class Path
{
    /**
     * @param array $path
     */
    public function __construct(
        private array $path,
    )
    {
    }

    /**
     * @param string $id
     * @return self
     */
    public static function fromString(string $id): self
    {
        return new self(explode('.', $id));
    }

    /**
     * @param array $path
     * @return self
     */
    public static function fromArray(array $path): self
    {
        return new self($path);
    }

    /**
     * @param string $path
     * @return static
     */
    public static function fromRoot(string $path): self
    {
        return new self([$path]);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function concat(string $id): self
    {
        return new self([...$this->path, $id]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function root(): string
    {
        return $this->path[0];
    }

    /**
     * @return string|array
     */
    public function toValue(): string|array
    {
        if (count($this->path) === 1) {
            return $this->path[0];
        }

        $value = null;
        foreach (array_reverse($this->path) as $part) {
            $value = $value ? [$part => $value] : $part;
        }

        return $value;
    }
}
