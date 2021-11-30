<?php
declare(strict_types=1);

namespace PumlParser\Node;

class Properties
{
    /**
     * @var Property[]
     */
    private array $properties;

    public function __construct(Property ...$properties)
    {
        $this->properties = $properties;
    }

    public function toArray(): array
    {
        return array_map(fn(Property $property) => $property->toArray(), $this->properties);
    }

    public function toDtos(): array
    {
        return array_map(fn(Property $property) => $property->toDto(), $this->properties);
    }

    public function add(Property $property): void
    {
        $this->properties[] = $property;
    }
}
