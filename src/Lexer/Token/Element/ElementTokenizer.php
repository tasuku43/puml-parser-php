<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\Exception\TokenizeException;
use PumlParser\Lexer\Tokenizeable;
use PumlParser\Lexer\TokenizeSupport;

class ElementTokenizer implements Tokenizeable
{
    use TokenizeSupport;

    public function parseable(string $contents): bool
    {
        return (bool) $this->contentsStartsWith($contents, [
            AbstractClassToken::SYMBOL,
            AbstractToken::SYMBOL,
            ClassToken::SYMBOL,
            EnumToken::SYMBOL,
            InterfaceToken::SYMBOL,
            NamespaceToken::SYMBOL,
            PackageToken::SYMBOL
        ]);
    }

    /**
     * @throws TokenizeException
     */
    public function parseForward(string $contents): ElementToken
    {
        return match (true) {
            str_starts_with($contents, PackageToken::SYMBOL) => new PackageToken(),
            str_starts_with($contents, ClassToken::SYMBOL) => new ClassToken(),
            str_starts_with($contents, AbstractClassToken::SYMBOL),
            str_starts_with($contents, AbstractToken::SYMBOL) => new AbstractClassToken(),
            str_starts_with($contents, InterfaceToken::SYMBOL) => new InterfaceToken(),
            str_starts_with($contents, EnumToken::SYMBOL) => new EnumToken(),
            default => throw new TokenizeException(sprintf('Parsing failed. contents: %s', $contents))
        };
    }
}
