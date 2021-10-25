<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

class OpenRoundBracketToken extends RoundBracketToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::CloseRoundBracket_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
