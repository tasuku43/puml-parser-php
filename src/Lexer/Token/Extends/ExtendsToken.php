<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Extends;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

class ExtendsToken implements Token
{
    use TokenSupport;

    public const SYMBOL = 'extends';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
