<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Extends;

use PumlParser\Lexer\Tokenizeable;

class ExtendsTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, ExtendsToken::SYMBOL);
    }

    public function parseForward(string $contents): ExtendsToken
    {
        assert($this->parseable($contents));

        return new ExtendsToken();
    }
}
