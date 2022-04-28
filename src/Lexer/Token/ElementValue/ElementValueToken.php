<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\ElementValue;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

class ElementValueToken implements Token
{
    use TokenSupport;

    public function __construct(private string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
