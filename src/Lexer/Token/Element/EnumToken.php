<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class EnumToken implements ElementToken
{
    public const SYMBOL = 'enum';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
