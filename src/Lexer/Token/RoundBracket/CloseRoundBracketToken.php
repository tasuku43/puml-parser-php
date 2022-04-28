<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

use PumlParser\Lexer\Token\TokenSupport;

class CloseRoundBracketToken extends RoundBracketToken
{
    use TokenSupport;

    public function getValue(): string
    {
        return self::OpenRoundBracket_;
    }
}
