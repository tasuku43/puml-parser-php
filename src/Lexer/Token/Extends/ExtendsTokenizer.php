<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Extends;

use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\TokenizeSupport;

class ExtendsTokenizer implements PumlTokenizer
{
    public const SYMBOL   = 'extends';

    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, self::SYMBOL);
    }

    public function parseForward(string $contents): ExtendsToken
    {
        return new ExtendsToken(self::SYMBOL);
    }
}
