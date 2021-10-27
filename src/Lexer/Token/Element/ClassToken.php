<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class ClassToken extends ElementToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::CLASS_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
