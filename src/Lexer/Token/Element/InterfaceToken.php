<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class InterfaceToken implements ElementToken
{
    public const SYMBOL = 'interface';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
