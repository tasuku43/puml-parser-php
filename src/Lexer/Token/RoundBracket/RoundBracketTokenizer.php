<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\TokenizeSupport;

class RoundBracketTokenizer implements PumlTokenizer
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, RoundBracketToken::symbols());
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): CloseRoundBracketToken|OpenRoundBracketToken
    {
        return match (true) {
            str_starts_with($contents, RoundBracketToken::OpenRoundBracket_) => new OpenRoundBracketToken(),
            str_starts_with($contents, RoundBracketToken::CloseRoundBracket_) => new CloseRoundBracketToken(),
            default => throw new TokenException()
        };
    }
}
