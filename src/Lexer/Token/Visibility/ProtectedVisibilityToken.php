<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

class ProtectedVisibilityToken implements VisibilityToken
{
    public const SYMBOL = '#';

    public function getValue(): string
    {
        return self::SYMBOL;
    }

    public function __toString(): string
    {
        return 'protected';
    }
}
