<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

/**
 * alias for AbstractClassToken
 *
 * Class AbstractToken
 * @package PumlParser\Lexer\Token\Element
 */
class AbstractToken  extends ClassRelatedToken
{
    public const SYMBOL = 'abstract';
}
