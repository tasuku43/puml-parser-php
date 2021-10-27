<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Arrow\ArrowToken;
use PumlParser\Lexer\Token\Arrow\LeftArrowToken;
use PumlParser\Lexer\Token\Arrow\RightArrowToken;
use PumlParser\Lexer\Token\Exception\TokenException;

trait TokenizeSupport
{
    private function contentsStartsWith(string $contents, array $needles): string|bool
    {
        foreach ($needles as $needle) {
            if (str_starts_with($contents, $needle)) return $needle;
        }

        return false;
    }

    /**
     * @throws TokenException
     */
    private function pregMatchContents(string $contents, string $pattern): string
    {
        preg_match($pattern, $contents, $match) ?: throw new TokenException();

        return $match[0];
    }

    private function isEndOfElementValue(string $contents): bool
    {
        foreach (Lexer::SKIP_STRINGS as $endCh) {
            if (str_starts_with($contents, $endCh)) return true;
        }

        if (preg_match(LeftArrowToken::PATTERN, $contents) === 1
            || preg_match(RightArrowToken::PATTERN, $contents) === 1) {
            return true;
        }

        return false;
    }
}
