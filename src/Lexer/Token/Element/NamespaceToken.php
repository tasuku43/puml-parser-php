<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class NamespaceToken extends ElementToken
{
    protected string $value = self::NAMESPACE_;
}
