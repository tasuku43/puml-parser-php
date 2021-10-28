<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Extends;

use PumlParser\Lexer\Token\Token;

class ExtendsToken implements Token
{
    public const SYMBOL = 'extends';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
