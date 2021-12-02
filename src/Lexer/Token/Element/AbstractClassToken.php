<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class AbstractClassToken implements ElementToken
{
    public const SYMBOL = 'abstract class';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
