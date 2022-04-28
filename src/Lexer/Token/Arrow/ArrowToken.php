<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class ArrowToken implements Token
{
    use TokenSupport;

    public function __construct(protected string $value)
    {
        assert(preg_match(static::PATTERN, $value) === 1);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
