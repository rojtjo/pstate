<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class StateValue
{
    /**
     * @param string|array $value
     */
    public function __construct(
        private string|array $value,
    )
    {
    }

    /**
     * @param string|array $value
     * @return static
     */
    public static function fromValue(string|array $value): self
    {
        return new self($value);
    }

    /**
     * @return string|array
     */
    public function toValue(): string|array
    {
        return $this->value;
    }

    /**
     * @return array<Path>
     */
    public function paths(): array
    {
        return self::nestedPaths($this->value);
    }

    /**
     * @param array<string, string|array> $stateValue
     * @param Path|null $parent
     * @return array<Path>
     * @psalm-pure
     */
    private static function nestedPaths(string|array $stateValue, Path $parent = null): array
    {
        if (is_string($stateValue)) {
            return [
                $parent?->concat($stateValue) ?? Path::fromRoot($stateValue),
            ];
        }

        $paths = [];
        foreach ($stateValue as $key => $value) {
            $paths = [
                ...$paths,
                ...self::nestedPaths($value, $parent?->concat($key) ?? Path::fromRoot($key)),
            ];
        }

        return $paths;
    }
}
