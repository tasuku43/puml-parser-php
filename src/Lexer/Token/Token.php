<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

interface Token
{
    public function getValue(): string;

    public function equals(Token $token): bool;
}
