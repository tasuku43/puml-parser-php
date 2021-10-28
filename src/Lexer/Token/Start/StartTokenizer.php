<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Start;

use PumlParser\Lexer\Tokenizeable;

class StartTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, StartToken::SYMBOL);
    }

    public function parseForward(string $contents): StartToken
    {
        return new StartToken();
    }
}
