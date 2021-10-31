<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class Interface_ extends ClassLike
{
    public function getType(): string
    {
        return 'interface';
    }
}

