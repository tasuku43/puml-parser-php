<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Arrow\ArrowTokenizer;
use PumlParser\Lexer\Token\CurlyBracket\CurlyBracketTokenizer;
use PumlParser\Lexer\Token\Element\ElementTokenizer;
use PumlParser\Lexer\Token\ElementValue\ElementValueTokenizer;
use PumlParser\Lexer\Token\End\EndTokenizer;
use PumlParser\Lexer\Token\Extends\ExtendsTokenizer;
use PumlParser\Lexer\Token\Implements\ImplementsTokenizer;
use PumlParser\Lexer\Token\Visibility\VisibilityTokenizer;
use PumlParser\Lexer\Token\RoundBracket\RoundBracketTokenizer;
use PumlParser\Lexer\Token\Start\StartTokenizer;
use PumlParser\Lexer\Token\Token;

class PumlTokenizer
{
    public function parseForward(string $contents): Token
    {
        foreach ($this->tokenizers() as $tokenizer) {
            if ($tokenizer->parseable($contents)) return $tokenizer->parseForward($contents);
        }

        return (new ElementValueTokenizer())->parseForward($contents);
    }

    /**
     * @return Tokenizeable[]
     */
    private function tokenizers(): array
    {
        return [
            new StartTokenizer(),
            new ElementTokenizer(),
            new ArrowTokenizer(),
            new CurlyBracketTokenizer(),
            new RoundBracketTokenizer(),
            new ExtendsTokenizer(),
            new ImplementsTokenizer(),
            new VisibilityTokenizer(),
            new EndTokenizer(),
        ];
    }
}
