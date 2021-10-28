<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class AbstractClassToken extends ElementToken
{
    protected string $value = self::ABSTRACT_CLASS_;
}
