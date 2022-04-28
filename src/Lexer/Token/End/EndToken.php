<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\End;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

class EndToken implements Token
{
    use TokenSupport;

    public const SYMBOL = '@enduml';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
