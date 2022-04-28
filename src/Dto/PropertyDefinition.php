<?php
declare(strict_types=1);

namespace PumlParser\Dto;

class PropertyDefinition
{
    public function __construct(private string $name, private string $visibility, private string $type)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
