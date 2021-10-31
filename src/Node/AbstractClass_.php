<?php
declare(strict_types=1);

namespace PumlParser\Node;

final class AbstractClass_ extends ClassLike
{
    public function getType(): string
    {
        return 'abstract class';
    }
}
