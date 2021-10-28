<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

class RightArrowToken extends ArrowToken
{
    public const PATTERN = "/^[.|-]+[*o>]/";
}
