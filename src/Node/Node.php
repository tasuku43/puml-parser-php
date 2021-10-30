<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\Difinition;

interface Node
{
    public function toArray(): array;

    public function toJson(): string;

    public function toDto(): Difinition;
}
