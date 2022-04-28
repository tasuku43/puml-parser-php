<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

class PrivateVisibilityToken extends VisibilityToken
{
    public const SYMBOL = '-';

    public function __toString(): string
    {
        return 'private';
    }
}
