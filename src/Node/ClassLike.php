<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\Difinition;

abstract class ClassLike implements Node
{
    protected Nodes $parents;
    protected Nodes $interfaces;

    public function __construct(protected string $name, protected string $package)
    {
        $this->parents    = Nodes::empty();
        $this->interfaces = Nodes::empty();
    }

    abstract public function getType(): string;

    public function getName(): string
    {
        return $this->name;
    }

    public function extends(ClassLike $class): self
    {
        $this->parents->add($class);

        return $this;
    }

    public function implements(ClassLike $class): self
    {
        $this->interfaces->add($class);

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'Name'       => $this->name,
                'Package'    => $this->package,
                'Parents'    => $this->parents->toArray(),
                'Interfaces' => $this->interfaces->toArray()
            ]
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toDto(): Difinition
    {
        return new Difinition(
            $this->name,
            $this->getType(),
            $this->package,
            $this->parents->toDtos(),
            $this->interfaces->toDtos());
    }
}
