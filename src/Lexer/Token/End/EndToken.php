<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\End;

use PumlParser\Lexer\Token\Token;

class EndToken implements Token
{
    public const SYMBOL = '@enduml';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
