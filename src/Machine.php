<?php

declare(strict_types=1);

namespace PState;

/** @psalm-immutable */
final class Machine extends StateNode
{
    public function transition(string $value, string $event): string
    {
        $path = Path::fromString($value);

        $current = $this->findStateNode($path);

        $target = $this->findTransition($current, $event);

        $next = $this->findStateNode($target);

        $nextState = Path::fromRoot()->append($target->toString());
        if ($next->isComplex()) {
            $nextState = $nextState->append($next->initial);
        }

        return $nextState->toString();
    }

    private function findStateNode(Path $path): StateNode
    {
        $node = $this;
        foreach ($path->toArray() as $part) {
            $node = $node->states[$part] ?? null;

            if ($node === null) {
                throw new \RuntimeException("Invalid state: {$path->toString()}");
            }
        }

        return $node;
    }

    private function findTransition(StateNode $node, string $event): Path
    {
        do {
            $target = $node->on[$event] ?? null;
            if ($target) {
                return Path::fromStateNode($node)->append($target);
            }

            $node = $node->parent;
        } while ($node->parent);

        throw new \RuntimeException("Transition not found for event: $event");
    }
}
