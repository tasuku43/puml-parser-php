<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\PropertyDefinition;

class Property
{
    public function __construct(private string $name, private string $visibility)
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'visibility' => $this->visibility,
        ];
    }

    public function toDto(): PropertyDefinition
    {
        return new PropertyDefinition(
            $this->name,
            $this->visibility,
        );
    }
}
