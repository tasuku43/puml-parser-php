<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Extends;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class ExtendsTokenizer implements Tokenizeable
{
    public const SYMBOL   = 'extends';

    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, self::SYMBOL);
    }

    public function parseForward(string $contents): ExtendsToken
    {
        assert($this->parseable($contents));

        return new ExtendsToken(self::SYMBOL);
    }
}
