<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class InterfaceToken extends ElementToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::INTERFACE_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
