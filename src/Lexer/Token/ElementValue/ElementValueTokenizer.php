<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\ElementValue;

use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\Token\Arrow\LeftArrowToken;
use PumlParser\Lexer\Token\Arrow\RightArrowToken;
use PumlParser\Lexer\Tokenizeable;

class ElementValueTokenizer implements Tokenizeable
{
    public function parseable(string $contents): bool
    {
        return true;
    }

    public function parseForward(string $contents): ElementValueToken
    {
        $return = '';

        do {
            if ($this->isEndOfElementValue($contents)) {
                break;
            }

            $return .= $contents[0];
        } while ($contents = substr($contents, 1));

        return new ElementValueToken($return);
    }

    private function isEndOfElementValue(string $contents): bool
    {
        foreach (Lexer::SKIP_STRINGS as $endCh) {
            if (str_starts_with($contents, $endCh)) return true;
        }

        if (preg_match(LeftArrowToken::PATTERN, $contents) === 1
            || preg_match(RightArrowToken::PATTERN, $contents) === 1) {
            return true;
        }

        return false;
    }
}
