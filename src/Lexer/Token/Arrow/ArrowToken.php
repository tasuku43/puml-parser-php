<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

use PumlParser\Lexer\Token\Token;

abstract class ArrowToken implements Token
{
    protected string $value;

    public function getValue(): string
    {
        return $this->value;
    }
}
