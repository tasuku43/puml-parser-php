<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Arrow\ArrowToken;
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

    private function isEndOfElementValue(string $ch): bool
    {
        foreach (array_merge(ArrowToken::symbols(), Lexer::SKIP_STRINGS) as $end_ch) {
            if ($ch === $end_ch) return true;
        }

        return false;
    }
}
