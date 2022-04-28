<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

class LeftArrowToken extends ArrowToken
{
    public const PATTERN = "/^[<o*][|.-]?[.-]*(up|down|left|right)?[.-]+/";
}
