<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

class CloseRoundBracketToken extends RoundBracketToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::OpenRoundBracket_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
