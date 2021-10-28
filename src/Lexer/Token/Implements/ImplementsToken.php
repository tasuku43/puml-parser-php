<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Implements;

use PumlParser\Lexer\Token\Token;

class ImplementsToken implements Token
{
    public const SYMBOL   = 'implements';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
