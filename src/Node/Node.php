<?php
declare(strict_types=1);

namespace PumlParser\Node;

interface Node
{
    public function toArray(): array;
}
