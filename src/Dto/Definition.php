<?php
declare(strict_types=1);

namespace PumlParser\Dto;

class Definition
{
    public function __construct(
        private string $name,
        private string $type,
        private string $package,
        private array $properties,
        private array $parents,
        private array $interfaces
    )
    {
        $this->package = str_replace("/", "\\", $package);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPackage(): string
    {
        return $this->package;
    }

    /**
     * @return Definition[]
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    public function getParentNames(): array
    {
        return array_map(function (Definition $definition) {
            return $definition->getName();
        }, $this->parents);
    }

    /**
     * @return Definition[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    public function getInterfaceNames(): array
    {
        return array_map(function (Definition $definition) {
            return $definition->getName();
        }, $this->interfaces);
    }

    /**
     * @return PropertyDefinition[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
