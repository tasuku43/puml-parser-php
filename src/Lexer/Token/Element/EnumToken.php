<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class EnumToken extends ElementToken
{
    protected string $value = self::ENUM_;
}
