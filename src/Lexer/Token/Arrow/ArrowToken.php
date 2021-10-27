<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class ArrowToken implements Token
{
    use TokenSupport;
}
