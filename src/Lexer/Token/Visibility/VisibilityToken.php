<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

use PumlParser\Lexer\Token\Token;

interface VisibilityToken extends Token
{
    public function __toString(): string;
}
