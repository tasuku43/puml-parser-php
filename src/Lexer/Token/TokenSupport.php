<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

trait TokenSupport
{
    public function __construct(protected string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
