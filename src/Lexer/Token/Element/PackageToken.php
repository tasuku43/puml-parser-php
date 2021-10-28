<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class PackageToken extends ElementToken
{
    protected string $value;

    public function __construct()
    {
        $this->value = self::PACKAGE_;
    }
}
