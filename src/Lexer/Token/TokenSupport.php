<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

trait TokenSupport
{
    abstract public function getValue(): string;

    public function equals(Token $token): bool
    {
        return get_class($this) === get_class($token)
            && $this->getValue() === $token->getValue();
    }
}
