<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class PackageToken extends ElementToken
{
    protected string $value = self::PACKAGE_;
}
