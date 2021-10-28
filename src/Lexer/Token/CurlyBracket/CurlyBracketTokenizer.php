<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\CurlyBracket;

use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class CurlyBracketTokenizer implements Tokenizeable
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, CurlyBracketToken::symbols());
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): OpenCurlyBracketToken|CloseCurlyBracketToken
    {
        return match (true) {
            str_starts_with($contents, CurlyBracketToken::OpenCurlyBracket_) => new OpenCurlyBracketToken(),
            str_starts_with($contents, CurlyBracketToken::CloseCurlyBracket_) => new CloseCurlyBracketToken(),
            default => throw new TokenException()
        };
    }
}