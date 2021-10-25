<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

class CloseCurlyBracketToken extends CurlyBracketToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::CloseCurlyBracket_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
