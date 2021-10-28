<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\ElementValue;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class ElementValueTokenizer implements Tokenizeable
{
    use TokenizeSupport;

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
}
