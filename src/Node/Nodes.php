<?php
declare(strict_types=1);

namespace PumlParser\Node;

class Nodes implements Node
{
    /**
     * @var Node[]
     */
    private array $nodes;

    public function __construct(Node ...$nodes)
    {
        $this->nodes = $nodes;
    }

    public static function empty(): self
    {
        return new Nodes();
    }

    public function toArray(): array
    {
        return array_map(fn($node) => $node->toArray(), $this->nodes);
    }

    public function add(Node $node): void
    {
        if (in_array($node, $this->nodes)) {
            return;
        }

        $this->nodes = array_merge($this->nodes, [$node]);
    }

    public function last(): Node
    {
        return $this->nodes[array_key_last($this->nodes)];
    }

    public function searchByName(string $name): ?ClassLike
    {
        foreach ($this->nodes as $node) {
            assert($node instanceof ClassLike);

            if ($node->getName() === $name) return $node;
        }

        return null;
    }
}
