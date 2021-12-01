<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class PackageToken implements ElementToken
{
    public const SYMBOL = 'package';

    public function getValue(): string
    {
        return self::SYMBOL;
    }
}
