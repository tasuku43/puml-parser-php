<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class PackageToken extends ElementToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::PACKAGE_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
