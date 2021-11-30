<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\PropertyDifinition;

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

    public function toDto(): PropertyDifinition
    {
        return new PropertyDifinition(
            $this->name,
            $this->visibility,
        );
    }
}
