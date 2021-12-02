<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

/**
 * alias for AbstractClassToken
 *
 * Class AbstractToken
 * @package PumlParser\Lexer\Token\Element
 */
class AbstractToken implements ElementToken
{
    public const SYMBOL = 'abstract';

    public function getValue(): string
    {
        return AbstractClassToken::SYMBOL;
    }
}
