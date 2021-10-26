<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class AbstractClassToken extends ElementToken
{
    private string $value;

    public function __construct()
    {
        $this->value = self::ABSTRACT_CLASS_;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
