<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class Interface_ extends ClassLike
{
    public function getType(): string
    {
        return 'Interface';
    }

    public function extends(Interface_ $interface): void
    {
        $this->parents->add($interface);
    }
}
