<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class AbstractClass_ extends ClassLike
{
    public function getType(): string
    {
        return 'AbstractClass';
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
