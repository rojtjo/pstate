<?php

declare(strict_types=1);

namespace PState;

/**
 * @psalm-immutable
 */
final class Transition
{
    /**
     * @var string
     */
    public string $event;

    /**
     * @var Path
     */
    public Path $target;

    /**
     * @param TransitionConfig $config
     * @param Path|null $parent
     */
    public function __construct(TransitionConfig $config, Path $parent = null)
    {
        $this->event = $config->event;
        $this->target = $parent?->concat($config->target) ?? Path::fromRoot($config->target);
    }
}
