<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class ClassToken extends ElementToken
{
    protected string $value;

    public function __construct()
    {
        $this->value = self::CLASS_;
    }
}
