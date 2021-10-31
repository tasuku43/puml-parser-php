<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class Class_ extends ClassLike
{
    public function getType(): string
    {
        return 'class';
    }
}
