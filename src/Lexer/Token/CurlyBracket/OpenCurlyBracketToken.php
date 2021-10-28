<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;


class OpenCurlyBracketToken extends CurlyBracketToken
{
    public const SYMBOL = '{';

    protected string $value = self::SYMBOL;
}
