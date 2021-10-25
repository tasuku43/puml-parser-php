<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\ElementValue;

use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\TokenizeSupport;

class ElementValueTokenizer implements PumlTokenizer
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return true;
    }

    public function parseForward(string $contents): ElementValueToken
    {
        $return = '';

        foreach (mb_str_split($contents) as $ch) {
            if ($this->isEndOfElementValue($ch)) {
                break;
            }

            $return .= $ch;
        }

        return new ElementValueToken($return);
    }
}
