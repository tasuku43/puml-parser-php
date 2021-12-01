<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class NamespaceToken implements ElementToken
{
    public const SYMBOL = 'namespace';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
