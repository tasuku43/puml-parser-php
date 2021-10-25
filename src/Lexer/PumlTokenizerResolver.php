<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Arrow\ArrowTokenizer;
use PumlParser\Lexer\Token\CurlyBracket\CurlyBracketTokenizer;
use PumlParser\Lexer\Token\Element\ElementTokenizer;
use PumlParser\Lexer\Token\ElementValue\ElementValueTokenizer;
use PumlParser\Lexer\Token\End\EofTokenizer;
use PumlParser\Lexer\Token\Start\StartTokenizer;
use PumlParser\Lexer\Token\RoundBracket\RoundBracketTokenizer;

class PumlTokenizerResolver
{
    public function resolve(string $contents): PumlTokenizer
    {
        foreach ($this->tokenizers() as $tokenizer) {
            if ($tokenizer->parseable($contents)) return $tokenizer;
        }

        return new ElementValueTokenizer();
    }

    /**
     * @return PumlTokenizer[]
     */
    private function tokenizers(): array
    {
        return [
            new StartTokenizer(),
            new ElementTokenizer(),
            new ArrowTokenizer(),
            new CurlyBracketTokenizer(),
            new RoundBracketTokenizer(),
            new EofTokenizer()
        ];
    }
}
