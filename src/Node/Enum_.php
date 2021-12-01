<?php
declare(strict_types=1);

namespace PumlParser\Node;

use PumlParser\Dto\Difinition;

final class Enum_ extends ClassLike
{
    /**
     * @var string[]
     */
    private array $cases = [];

    public function __construct(
        protected string $name,
        protected string $package,
    )
    {
        parent::__construct($name, $package);
    }

    public function addCases(string $case): self
    {
        $this->cases[] = $case;

        return $this;
    }

    public function getType(): string
    {
        return 'enum';
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'Name'       => $this->name,
                'Package'    => $this->package,
                'Cases'      => $this->cases,
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
            cases: $this->cases,
            parents: $this->parents->toDtos(),
            interfaces: $this->interfaces->toDtos());
    }
}
