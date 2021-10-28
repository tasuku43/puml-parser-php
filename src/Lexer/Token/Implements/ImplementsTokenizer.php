<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Implements;

use PumlParser\Lexer\Tokenizeable;

class ImplementsTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, ImplementsToken::SYMBOL);
    }

    public function parseForward(string $contents): ImplementsToken
    {
        return new ImplementsToken();
    }
}
