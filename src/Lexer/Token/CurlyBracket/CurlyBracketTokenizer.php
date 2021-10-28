<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class CurlyBracketTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, OpenCurlyBracketToken::SYMBOL)
            || str_starts_with($contents, CloseCurlyBracketToken::SYMBOL);
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): OpenCurlyBracketToken|CloseCurlyBracketToken
    {
        return match (true) {
            str_starts_with($contents, OpenCurlyBracketToken::SYMBOL) => new OpenCurlyBracketToken(),
            str_starts_with($contents, CloseCurlyBracketToken::SYMBOL) => new CloseCurlyBracketToken(),
            default => throw new TokenException()
        };
    }
}