<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class CurlyBracketToken implements Token
{
    use TokenSupport;

    public function getValue(): string
    {
        return static::SYMBOL;
    }
}
