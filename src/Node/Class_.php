<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class Class_ extends ClassLike
{
    public function getType(): string
    {
        return 'Class';
    }

    public function extends(Class_|AbstractClass_ $class): void
    {
        $this->parents->add($class);
    }

    public function implements(Interface_ $interface): void
    {
        $this->interfaces->add($interface);
    }
}
