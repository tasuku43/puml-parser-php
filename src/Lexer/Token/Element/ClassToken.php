<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class ClassToken implements ElementToken
{
    public const SYMBOL = 'class';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
