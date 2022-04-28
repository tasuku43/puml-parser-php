<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class VisibilityToken implements Token
{
    use TokenSupport;

    public function getValue(): string
    {
        return static::SYMBOL;
    }

    abstract public function __toString(): string;
}
