<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class ElementTokenizer implements Tokenizeable
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, ElementToken::symbols());
    }

    /**
     * @throws TokenException
     */
    public function parseForward(string $contents): ElementToken
    {
        return match (true) {
            str_starts_with($contents, ElementToken::PACKAGE_) => new PackageToken(),
            str_starts_with($contents, ElementToken::CLASS_) => new ClassToken(),
            str_starts_with($contents, ElementToken::ABSTRACT_CLASS_) => new AbstractClassToken(),
            str_starts_with($contents, ElementToken::INTERFACE_) => new InterfaceToken(),
            default => throw new TokenException()
        };
    }
}
