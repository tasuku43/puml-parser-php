<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Start;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class StartTokenizer implements Tokenizeable
{
    public const PUML_START = '@startuml';

    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, self::PUML_START);
    }

    public function parseForward(string $contents): StartToken
    {
        return new StartToken(self::PUML_START);
    }
}
