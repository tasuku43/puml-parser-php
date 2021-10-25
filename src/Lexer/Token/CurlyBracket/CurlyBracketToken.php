<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

use PumlParser\Lexer\Token\Token;

abstract class CurlyBracketToken implements Token
{
    public const OpenCurlyBracket_  = '{';
    public const CloseCurlyBracket_ = '}';

    public static function symbols(): array
    {
        return [
            self::OpenCurlyBracket_,
            self::CloseCurlyBracket_,
        ];
    }
}
