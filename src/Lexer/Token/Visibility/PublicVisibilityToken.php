<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

class PublicVisibilityToken extends VisibilityToken
{
    public const SYMBOL = '+';

    public function __toString(): string
    {
        return 'public';
    }
}
