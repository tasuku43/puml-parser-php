<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\TokenizeSupport;

class ElementTokenizer implements PumlTokenizer
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, ElementToken::symbols());
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): ElementToken
    {
        foreach (ElementToken::symbols() as $symbol) {
            if (str_starts_with($contents, $symbol)) return new ElementToken($symbol);
        }

        throw new TokenException();
    }
}
