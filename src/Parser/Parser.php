<?php
declare(strict_types=1);

namespace PumlParser\Parser;

use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\Token\CurlyBracket\CloseCurlyBracketToken;
use PumlParser\Lexer\Token\CurlyBracket\OpenCurlyBracketToken;
use PumlParser\Lexer\Token\Element\AbstractClassToken;
use PumlParser\Lexer\Token\Element\ClassToken;
use PumlParser\Lexer\Token\Element\ElementToken;
use PumlParser\Lexer\Token\Element\InterfaceToken;
use PumlParser\Lexer\Token\Element\PackageToken;
use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\End\EndToken;
use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Token\Extends\ExtendsToken;
use PumlParser\Lexer\Token\Implements\ImplementsToken;
use PumlParser\Lexer\Token\Start\StartToken;
use PumlParser\Lexer\Token\Token;
use PumlParser\Node\AbstractClass_;
use PumlParser\Node\Class_;
use PumlParser\Node\ClassLike;
use PumlParser\Node\Interface_;
use PumlParser\Node\Node;
use PumlParser\Node\Nodes;
use PumlParser\Parser\Exception\ParserException;

class Parser
{
    private Nodes $nodes;

    public function __construct(private Lexer $lexer)
    {
        $this->nodes = Nodes::empty();
    }

    /**
     * @throws ParserException
     * @throws TokenException
     */
    public function parse(): Nodes
    {
        $token = $this->lexer->getNextToken();

        if ($token instanceof StartToken) return $this->parse();
        if ($token instanceof PackageToken) return $this->parseInPackage();

        if ($this->isClassLikeToken($token)) {
            assert($token instanceof ElementToken);

            $this->nodes->add($this->parseClassLike($token, $this->lexer->getNextElementValueToken()));

            return $this->parse();
        } elseif ($token instanceof ExtendsToken) {
            $this->parseExtends($this->lexer->getNextElementValueToken());

            return $this->parse();
        } elseif ($token instanceof ImplementsToken) {
            $this->parseImplements($this->lexer->getNextElementValueToken());

            return $this->parse();
        }

        return $this->nodes;
    }

    /**
     * @throws ParserException
     * @throws TokenException
     */
    private function parseInPackage(): Nodes
    {
        $package = $this->lexer->getNextToken()->getValue();

        $depth = 0;

        while ($token = $this->lexer->getNextToken()) {
            if ($token instanceof OpenCurlyBracketToken) {
                $depth++;
            } elseif ($token instanceof CloseCurlyBracketToken) {
                $depth--;

                if ($depth === 0) break;
            }

            if ($token instanceof PackageToken) {
                return $this->parseInPackage();
            } elseif ($this->isClassLikeToken($token)) {
                $this->nodes->add($this->parseClassLike($token, $this->lexer->getNextElementValueToken(), $package));
            } elseif ($token instanceof ExtendsToken) {
                $this->parseExtends($this->lexer->getNextElementValueToken());
            } elseif ($token instanceof ImplementsToken) {
                $this->parseImplements($this->lexer->getNextElementValueToken());
            } elseif ($token instanceof EndToken) {
                return $this->nodes;
            }
        }

        return $this->parse();
    }

    private function parseClassLike(
        ElementToken $elementToken,
        ElementValueToken $valueToken,
        string $currentPackage = ''
    ): Node
    {
        return match (true) {
            $elementToken instanceof ClassToken         => new Class_($valueToken->getValue(), $currentPackage),
            $elementToken instanceof AbstractClassToken => new AbstractClass_($valueToken->getValue(), $currentPackage),
            $elementToken instanceof InterfaceToken     => new Interface_($valueToken->getValue(), $currentPackage),
        };
    }

    /**
     * @throws ParserException
     */
    private function parseImplements(ElementValueToken $valueToken): void
    {
        $lastClassLike = $this->nodes->last();
        assert($lastClassLike instanceof ClassLike);

        $interface = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        $lastClassLike->implements($interface);
    }

    /**
     * @throws ParserException
     */
    private function parseExtends(ElementValueToken $valueToken): void
    {
        $lastClassLike = $this->nodes->last();
        assert($lastClassLike instanceof ClassLike);

        $class = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        $lastClassLike->extends($class);
    }

    private function isClassLikeToken(Token $token): bool
    {
        return $token instanceof ClassToken || $token instanceof AbstractClassToken || $token instanceof InterfaceToken;
    }
}
