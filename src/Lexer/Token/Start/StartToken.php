<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Start;

use PumlParser\Lexer\Token\Token;

class StartToken implements Token
{
    public const SYMBOL = '@startuml';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
