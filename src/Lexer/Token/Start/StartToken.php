<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Start;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

class StartToken implements Token
{
    public const SYMBOL = '@startuml';

    use TokenSupport;

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
