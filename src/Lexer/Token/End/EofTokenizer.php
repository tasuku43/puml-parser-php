<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\End;

use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\Token\End\EndToken;
use PumlParser\Lexer\TokenizeSupport;

class EofTokenizer implements PumlTokenizer
{
    public const PUML_END   = '@enduml';

    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return str_starts_with($contents, self::PUML_END);
    }

    public function parseForward(string $contents): EndToken
    {
        return new EndToken(self::PUML_END);
    }
}
