<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\Definition;

interface Node
{
    public function toArray(): array;

    public function toJson(): string;

    public function toDto(): Definition;
}
