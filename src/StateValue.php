<?php

declare(strict_types=1);

namespace PState;

/** @psalm-immutable */
final class StateValue
{
    private const DELIMITER = '.';

    public function __construct(
        private array $value,
    )
    {
    }

    public static function fromArray(array $value): self
    {
        return new self($value);
    }

    public function fromString(string $value): self
    {
        $parts = explode(self::DELIMITER, $value);
    }

    public function toArray(): array
    {
        return $this->value;
    }
}
