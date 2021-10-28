<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

trait TokenizeSupport
{
    private function contentsStartsWith(string $contents, array $needles): string|bool
    {
        foreach ($needles as $needle) {
            if (str_starts_with($contents, $needle)) return $needle;
        }

        return false;
    }
}
