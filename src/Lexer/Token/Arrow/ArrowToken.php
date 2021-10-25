<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class ArrowToken implements Token
{
    use TokenSupport;

    public const LEFT_ANGLE_BRACKET_ = '<';
    public const DOT_                = '.';
    public const HYPHEN_             = '-';
    public const O_                  = 'o';
    public const ASTERISK_           = '*';

    public static function symbols(): array
    {
        return [
            self::LEFT_ANGLE_BRACKET_,
            self::DOT_,
            self::HYPHEN_,
            self::O_,
            self::ASTERISK_,
        ];
    }
}
