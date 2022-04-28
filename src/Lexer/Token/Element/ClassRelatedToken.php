<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\TokenSupport;

abstract class ClassRelatedToken implements ElementToken
{
    use TokenSupport;

    public function getValue(): string
    {
        return static::SYMBOL;
    }
}
