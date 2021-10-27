<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\TokenizeSupport;

class ArrowTokenizer implements PumlTokenizer
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return preg_match(LeftArrowToken::PATTERN, $contents) === 1
            || preg_match(RightArrowToken::PATTERN, $contents) === 1;
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): LeftArrowToken|RightArrowToken
    {
        return match (true) {
            preg_match(LeftArrowToken::PATTERN, $contents) === 1 => new LeftArrowToken(
                $this->pregMatchContents($contents, LeftArrowToken::PATTERN)
            ),
            preg_match(RightArrowToken::PATTERN, $contents) === 1 => new RightArrowToken(
                $this->pregMatchContents($contents, RightArrowToken::PATTERN)
            ),
            default       => throw new TokenException()
        };
    }
}