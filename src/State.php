<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class State
{
    /**
     * @param StateValue $value
     */
    public function __construct(
        private StateValue $value,
    )
    {
    }

    /**
     * @param string|array|StateValue $stateValue
     * @return static
     * @psalm-pure
     */
    public static function fromValue(string|array|StateValue $stateValue): self
    {
        if ( ! $stateValue instanceof StateValue) {
            $stateValue = StateValue::fromValue($stateValue);
        }

        return new self($stateValue);
    }

    /**
     * @return array|string
     */
    public function value(): array|string
    {
        return $this->value->toValue();
    }

    /**
     * @return array<Path>
     * @psalm-pure
     */
    public function paths(): array
    {
        return $this->value->paths();
    }
}
