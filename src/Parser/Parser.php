<?php
declare(strict_types=1);

namespace PumlParser\Parser;

use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\Token\Arrow\LeftArrowToken;
use PumlParser\Lexer\Token\Arrow\RightArrowToken;
use PumlParser\Lexer\Token\CurlyBracket\CloseCurlyBracketToken;
use PumlParser\Lexer\Token\CurlyBracket\OpenCurlyBracketToken;
use PumlParser\Lexer\Token\Element\AbstractClassToken;
use PumlParser\Lexer\Token\Element\ClassToken;
use PumlParser\Lexer\Token\Element\InterfaceToken;
use PumlParser\Lexer\Token\Element\PackageToken;
use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\End\EndToken;
use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Token\Extends\ExtendsToken;
use PumlParser\Lexer\Token\Implements\ImplementsToken;
use PumlParser\Lexer\Token\Token;
use PumlParser\Node\AbstractClass_;
use PumlParser\Node\Class_;
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
        do {
            $token = $this->lexer->next();

            $this->parseToken($token);
        } while (!$token instanceof EndToken);

        return $this->nodes;
    }

    /**
     * @param Token $token
     * @param string $package
     * @throws ParserException
     * @throws TokenException
     */
    private function parseToken(Token $token, string $package = ''): void
    {
        switch (true) {
            case $token instanceof PackageToken:
                $package = $this->lexer->next()->getValue();
                $this->parseInPackage($package);
                break;
            case $token instanceof ClassToken || $token instanceof AbstractClassToken || $token instanceof InterfaceToken:
                $this->nodes->add($this->parseClassLike($token, $this->lexer->nextElementValueToken(), $package));
                break;
            case $token instanceof ExtendsToken:
                $this->parseExtends($this->lexer->nextElementValueToken());
                break;
            case $token instanceof ImplementsToken:
                $this->parseImplements($this->lexer->nextElementValueToken());
                break;
            case $token instanceof LeftArrowToken:
                $this->parseLeftArrow($token);
                break;
            case $token instanceof RightArrowToken:
                $this->parseRightArrow($token);
                break;
        }
    }

    /**
     * @throws ParserException
     * @throws TokenException
     */
    private function parseInPackage(string $package): void
    {
        $depth = 0;

        do {
            $token = $this->lexer->next();

            if ($token instanceof OpenCurlyBracketToken) {
                $depth++;
                continue;
            } elseif ($token instanceof CloseCurlyBracketToken) {
                $depth--;
                continue;
            }

            $this->parseToken($token, $package);
        } while ($depth !== 0);
    }

    private function parseClassLike(
        ClassToken|AbstractClassToken|InterfaceToken $elementToken,
        ElementValueToken $valueToken,
        string $package = ''
    ): Node
    {
         return match (true) {
            $elementToken instanceof ClassToken         => new Class_($valueToken->getValue(), $package),
            $elementToken instanceof AbstractClassToken => new AbstractClass_($valueToken->getValue(), $package),
            $elementToken instanceof InterfaceToken     => new Interface_($valueToken->getValue(), $package),
        };
    }

    /**
     * @throws ParserException
     */
    private function parseImplements(ElementValueToken $valueToken): Node
    {
        $classLike = $this->nodes->searchByName($this->lexer->prev(2)->getValue()) ?? throw new ParserException();
        $interface = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        return $classLike->implements($interface);
    }

    /**
     * @throws ParserException
     */
    private function parseExtends(ElementValueToken $valueToken): Node
    {
        $classLike = $this->nodes->searchByName($this->lexer->prev(2)->getValue()) ?? throw new ParserException();
        $parent    = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        return $classLike->extends($parent);
    }

    /**
     * @throws ParserException
     * @throws TokenException
     */
    private function parseLeftArrow(LeftArrowToken $token): Node
    {
        switch (true) {
            case str_starts_with($token->getValue(), '<|.'):
                $classLike = $this->nodes->searchByName($this->lexer->prev()->getValue()) ?? throw new ParserException();

                $valueToken = $this->lexer->nextElementValueToken();

                $class = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

                return $class->implements($classLike);
            case str_starts_with($token->getValue(), '<|-'):
                $classLike = $this->nodes->searchByName($this->lexer->prev()->getValue()) ?? throw new ParserException();

                $valueToken = $this->lexer->nextElementValueToken();

                $class = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

                return $class->extends($classLike);
            case str_starts_with($token->getValue(), '<-'):
                assert(false, 'Still no support.');
            case str_starts_with($token->getValue(), '<.'):
                assert(false, 'Still no support.');
            case str_starts_with($token->getValue(), 'o-'):
                assert(false, 'Still no support.');
            case str_starts_with($token->getValue(), 'o.'):
                assert(false, 'Still no support.');
            case str_starts_with($token->getValue(), '*-'):
                assert(false, 'Still no support.');
            case str_starts_with($token->getValue(), '*.'):
                assert(false, 'Still no support.');
        }
    }

    /**
     * @throws ParserException
     * @throws TokenException
     */
    private function parseRightArrow(RightArrowToken $token): Node
    {
        switch (true) {
            case str_ends_with($token->getValue(), '.|>'):
                $lastClassLike = $this->nodes->searchByName($this->lexer->prev()->getValue()) ?? throw new ParserException();

                $valueToken = $this->lexer->nextElementValueToken();

                $class = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

                return $lastClassLike->implements($class);
            case str_ends_with($token->getValue(), '-|>'):
                $lastClassLike = $this->nodes->searchByName($this->lexer->prev()->getValue()) ?? throw new ParserException();

                $valueToken = $this->lexer->nextElementValueToken();

                $class = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

                return $lastClassLike->extends($class);
            case str_ends_with($token->getValue(), '->'):
                assert(false, 'Still no support.');
            case str_ends_with($token->getValue(), '.>'):
                assert(false, 'Still no support.');
            case str_ends_with($token->getValue(), '-o'):
                assert(false, 'Still no support.');
            case str_ends_with($token->getValue(), '.o'):
                assert(false, 'Still no support.');
            case str_ends_with($token->getValue(), '-*'):
                assert(false, 'Still no support.');
            case str_ends_with($token->getValue(), '.*'):
                assert(false, 'Still no support.');
        }
    }
}
