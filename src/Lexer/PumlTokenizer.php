<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Token;

interface PumlTokenizer
{
    public function parseable(string $contents): bool;

    public function parseForward(string $contents): Token;
}
