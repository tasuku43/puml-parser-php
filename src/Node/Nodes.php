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

    public function add(Node $node)
    {
        $this->nodes = array_merge($this->nodes, [$node]);
    }
}
