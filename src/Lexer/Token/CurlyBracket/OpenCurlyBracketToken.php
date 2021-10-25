<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;


class OpenCurlyBracketToken extends CurlyBracketToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::OpenCurlyBracket_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
