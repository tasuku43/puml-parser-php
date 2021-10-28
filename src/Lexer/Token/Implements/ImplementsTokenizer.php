<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Implements;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class ImplementsTokenizer implements Tokenizeable
{
    public const SYMBOL   = 'implements';

    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, self::SYMBOL);
    }

    public function parseForward(string $contents): ImplementsToken
    {
        return new ImplementsToken(self::SYMBOL);
    }
}
