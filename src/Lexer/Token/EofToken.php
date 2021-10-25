<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

use PumlParser\Lexer\Token\Exception\TokenException;

class EofToken implements Token
{
    /**
     * @throws TokenException
     */
    public function getValue(): string
    {
        throw new TokenException();
    }
}
