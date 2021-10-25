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
        return (bool) $this->contentsStartsWith($contents, ArrowToken::symbols());
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): LeftArrowToken|RightArrowToken
    {
        return match ($contents[0]) {
            '<', 'o', '*' => new LeftArrowToken($this->pregMatchContents($contents, LeftArrowToken::PATTERN)),
            '.', '-'      => new RightArrowToken($this->pregMatchContents($contents, RightArrowToken::PATTERN)),
            default       => throw new TokenException()
        };
    }
}