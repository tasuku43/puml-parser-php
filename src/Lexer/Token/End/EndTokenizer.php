<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\End;

use PumlParser\Lexer\Tokenizeable;

class EndTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, EndToken::SYMBOL);
    }

    public function parseForward(string $contents): EndToken
    {
        return new EndToken();
    }
}
