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
use PumlParser\Lexer\Token\Extends\ExtendsToken;
use PumlParser\Lexer\Token\Implements\ImplementsToken;
use PumlParser\Lexer\Token\Start\StartToken;
use PumlParser\Node\AbstractClass_;
use PumlParser\Node\Class_;
use PumlParser\Node\ClassLike;
use PumlParser\Node\Interface_;
use PumlParser\Node\Nodes;
use PumlParser\Parser\Exception\ParserException;

class Parser
{
    private Nodes  $nodes;
    private string $package;

    public function __construct(private Lexer $lexer)
    {
        $this->package      = '';
        $this->nodes        = Nodes::empty();
    }

    /**
     * @throws ParserException
     */
    public function parse(): Nodes
    {
        $token = $this->lexer->getNextToken();

        return match (true) {
            $token instanceof StartToken, $token instanceof OpenCurlyBracketToken, $token instanceof CloseCurlyBracketToken => $this->parse(),
            $token instanceof ClassToken,
                $token instanceof AbstractClassToken,
                $token instanceof InterfaceToken => $this->parseClassLike($token),
            $token instanceof PackageToken => $this->parsePackage(),
            $token instanceof ExtendsToken => $this->parseExtends(),
            $token instanceof ImplementsToken => $this->parseImplements(),
            $token instanceof EndToken => $this->nodes
        };
    }

    /**
     * @throws ParserException
     */
    private function parsePackage(): Nodes
    {
        $packageValueToken = $this->lexer->getNextToken();
        assert($packageValueToken instanceof ElementValueToken);

        $this->package = $packageValueToken->getValue();

        return $this->parse();
    }

    private function parseClassLike(ElementToken $token): Nodes
    {
        $valueToken = $this->lexer->getNextToken();
        assert($valueToken instanceof ElementValueToken);

        $currentPackage = $this->package;

        $classLike = match (true) {
            $token instanceof ClassToken => new Class_($valueToken->getValue(), $currentPackage),
            $token instanceof AbstractClassToken => new AbstractClass_($valueToken->getValue(), $currentPackage),
            $token instanceof InterfaceToken => new Interface_($valueToken->getValue(), $currentPackage),
        };

        $this->nodes->add($classLike);

        return $this->parse();
    }

    /**
     * @throws ParserException
     */
    private function parseImplements(): Nodes
    {
        $valueToken = $this->lexer->getNextToken();
        assert($valueToken instanceof ElementValueToken);

        $lastClassLike = $this->nodes->last();
        assert($lastClassLike instanceof ClassLike);

        $interface = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        $lastClassLike->implements($interface);

        return $this->parse();
    }

    /**
     * @throws ParserException
     */
    private function parseExtends(): Nodes
    {
        $valueToken = $this->lexer->getNextToken();
        assert($valueToken instanceof ElementValueToken);

        $lastClassLike = $this->nodes->last();
        assert($lastClassLike instanceof ClassLike);

        $classLike = $this->nodes->searchByName($valueToken->getValue()) ?? throw new ParserException();

        $lastClassLike->extends($classLike);

        return $this->parse();
    }
}
