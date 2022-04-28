<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

class AbstractClassToken extends ClassRelatedToken
{
    public const SYMBOL = 'abstract class';
}
