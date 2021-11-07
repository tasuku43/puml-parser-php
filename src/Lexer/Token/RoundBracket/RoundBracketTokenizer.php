<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\RoundBracket;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\Token\Exception\TokenizeException;
use PumlParser\Lexer\TokenizeSupport;

class RoundBracketTokenizer implements Tokenizeable
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, RoundBracketToken::symbols());
    }

    /**
     * @throws TokenizeException
     */
    public function parseForward(string $contents): CloseRoundBracketToken|OpenRoundBracketToken
    {
        return match (true) {
            str_starts_with($contents, RoundBracketToken::OpenRoundBracket_) => new OpenRoundBracketToken(),
            str_starts_with($contents, RoundBracketToken::CloseRoundBracket_) => new CloseRoundBracketToken(),
            default => throw new TokenizeException(sprintf('Parsing failed. contents: %s', $contents))
        };
    }
}
