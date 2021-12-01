<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\Difinition;

final class AbstractClass_ extends ClassLike
{
    private Properties $propaties;

    public function __construct(
        protected string $name,
        protected string $package,
    )
    {
        parent::__construct($name, $package);

        $this->propaties = new Properties();
    }

    public function addProperty(Property $property): self
    {
        $this->propaties->add($property);

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'Name'       => $this->name,
                'Package'    => $this->package,
                'Propaties'  => $this->propaties->toArray(),
                'Parents'    => $this->parents->toArray(),
                'Interfaces' => $this->interfaces->toArray()
            ]
        ];
    }

    public function toDto(): Difinition
    {
        return new Difinition(
            name: $this->name,
            type: $this->getType(),
            package: $this->package,
            properties: $this->propaties->toDtos(),
            parents: $this->parents->toDtos(),
            interfaces: $this->interfaces->toDtos());
    }

    public function getType(): string
    {
        return 'abstract class';
    }
}
