<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Visibility;

use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class VisibilityTokenizer implements Tokenizeable
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, [
            PublicVisibilityToken::SYMBOL,
            ProtectedVisibilityToken::SYMBOL,
            PrivateVisibilityToken::SYMBOL,
        ]);
    }

    public function parseForward(string $contents): VisibilityToken
    {
        assert($this->parseable($contents));

        return match ($contents[0]) {
            PublicVisibilityToken::SYMBOL => new PublicVisibilityToken(),
            ProtectedVisibilityToken::SYMBOL => new ProtectedVisibilityToken(),
            PrivateVisibilityToken::SYMBOL => new PrivateVisibilityToken(),
        };
    }
}
