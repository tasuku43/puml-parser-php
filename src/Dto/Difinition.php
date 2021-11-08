<?php
declare(strict_types=1);

namespace PumlParser\Dto;

class Difinition
{
    public function __construct(
        private string $name,
        private string $type,
        private string $package,
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
     * @return Difinition[]
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    public function getParentNames(): array
    {
        return array_map(function (Difinition $difinition) {
            return $difinition->getName();
        }, $this->parents);
    }

    /**
     * @return Difinition[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    public function getInterfaceNames(): array
    {
        return array_map(function (Difinition $difinition) {
            return $difinition->getName();
        }, $this->interfaces);
    }
}
