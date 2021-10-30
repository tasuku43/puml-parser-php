<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Arrow;

class LeftArrowToken extends ArrowToken
{
    public const PATTERN = "/^[<o*][|.-]?[.-]*(up|down|left|right)?[.-]*/";

    protected string $value;

    public function __construct(string $value)
    {
        assert(preg_match(self::PATTERN, $value) === 1);

        $this->value = $value;
    }
}
