<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

use PumlParser\Lexer\Token\Token;

abstract class CurlyBracketToken implements Token
{
    protected string $value;

    public static function symbols(): array
    {
        return [
            self::OpenCurlyBracket_,
            self::CloseCurlyBracket_,
        ];
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
