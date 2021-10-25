<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

use PumlParser\Lexer\Token\Token;

abstract class RoundBracketToken implements Token
{
    public const OpenRoundBracket_  = '(';
    public const CloseRoundBracket_ = ')';

    public static function symbols(): array
    {
        return [
            self::OpenRoundBracket_,
            self::CloseRoundBracket_
        ];
    }
}
