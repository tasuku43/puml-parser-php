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
use PumlParser\Lexer\Token\Exception\TokenizeException;
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
    private Lexer $lexer;

    public function __construct()
    {
        $this->initializeNodes();
        $this->initializeLexer();
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
     */
    public function parse(string $pumlFilePath): Nodes
    {
        $this->lexer = Lexer::fromSourceFile($pumlFilePath);

        do {
            $token = $this->lexer->next();

            $this->parseToken($token);
        } while (!$token instanceof EndToken);

        return $this->postProcessing();
    }

    /**
     * @param Token $token
     * @param string $package
     * @throws ParserException
     * @throws TokenizeException
     */
    private function parseToken(Token $token, string $package = ''): void
    {
        switch (true) {
            case $token instanceof PackageToken:
                $package = $this->lexer->next()->getValue();
                $this->parseInPackage($package);
                break;
            case $token instanceof ClassToken || $token instanceof AbstractClassToken || $token instanceof InterfaceToken:
                $this->parseClassLike($token, $this->lexer->nextElementValueToken(), $package);
                break;
            case $token instanceof ExtendsToken:
                $childNameToken  = $this->lexer->prevElementValueToken();
                $parentNameToken = $this->lexer->nextElementValueToken();

                $this->parseExtends($childNameToken, $parentNameToken, $package);
                break;
            case $token instanceof ImplementsToken:
                $childNameToken  = $this->lexer->prevElementValueToken();
                $parentNameToken = $this->lexer->nextElementValueToken();

                $this->parseImplements($childNameToken, $parentNameToken, $package);
                break;
            case $token instanceof LeftArrowToken:
                $this->parseLeftArrow($token, $package);
                break;
            case $token instanceof RightArrowToken:
                $this->parseRightArrow($token, $package);
                break;
        }
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
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
    ): void
    {
        $node = match (true) {
            $elementToken instanceof ClassToken => new Class_($valueToken->getValue(), $package),
            $elementToken instanceof AbstractClassToken => new AbstractClass_($valueToken->getValue(), $package),
            $elementToken instanceof InterfaceToken => new Interface_($valueToken->getValue(), $package),
        };

        $this->nodes->add($node);
    }

    private function parseImplements(
        ElementValueToken $childNameToken,
        ElementValueToken $parentNameToken,
        string $package = ''
    ): void
    {
        $classLike = $this->nodes->searchByName($childNameToken->getValue()) ?? $this->createUndefinedClass($childNameToken, $package);
        $interface = $this->nodes->searchByName($parentNameToken->getValue()) ?? $this->createUndefinedClass($parentNameToken, $package);

        $classLike->implements($interface);
    }

    private function parseExtends(
        ElementValueToken $childNameToken,
        ElementValueToken $parentNameToken,
        string $package = ''
    ): void
    {
        $classLike = $this->nodes->searchByName($childNameToken->getValue()) ?? $this->createUndefinedClass($childNameToken, $package);
        $parent    = $this->nodes->searchByName($parentNameToken->getValue()) ?? $this->createUndefinedClass($parentNameToken, $package);

        $classLike->extends($parent);
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
     */
    private function parseLeftArrow(LeftArrowToken $token, string $package = ''): void
    {
        switch (true) {
            case str_starts_with($token->getValue(), '<|up.'):
            case str_starts_with($token->getValue(), '<|down.'):
            case str_starts_with($token->getValue(), '<|left.'):
            case str_starts_with($token->getValue(), '<|right.'):
            case str_starts_with($token->getValue(), '<|.'):
                $parentNameToken = $this->lexer->prevElementValueToken();
                $childNameToken  = $this->lexer->nextElementValueToken();

                $this->parseImplements($childNameToken, $parentNameToken, $package);
                break;
            case str_starts_with($token->getValue(), '<|up-'):
            case str_starts_with($token->getValue(), '<|down-'):
            case str_starts_with($token->getValue(), '<|left-'):
            case str_starts_with($token->getValue(), '<|right-'):
            case str_starts_with($token->getValue(), '<|-'):
                $parentNameToken = $this->lexer->prevElementValueToken();
                $childNameToken  = $this->lexer->nextElementValueToken();

                $this->parseExtends($childNameToken, $parentNameToken, $package);
                break;
            case str_starts_with($token->getValue(), '<-'):
            case str_starts_with($token->getValue(), '<.'):
            case str_starts_with($token->getValue(), 'o-'):
            case str_starts_with($token->getValue(), 'o.'):
            case str_starts_with($token->getValue(), '*-'):
            case str_starts_with($token->getValue(), '*.'):
//                fwrite(STDOUT, sprintf("Skip parsing of '%s'. Still no support.\n", $token->getValue()));
                break;
        }
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
     */
    private function parseRightArrow(RightArrowToken $token, string $package = ''): void
    {
        switch (true) {
            case str_ends_with($token->getValue(), '.up|>'):
            case str_ends_with($token->getValue(), '.down|>'):
            case str_ends_with($token->getValue(), '.left|>'):
            case str_ends_with($token->getValue(), '.right|>'):
            case str_ends_with($token->getValue(), '.|>'):
                $childNameToken  = $this->lexer->prevElementValueToken();
                $parentNameToken = $this->lexer->nextElementValueToken();

                $this->parseImplements($childNameToken, $parentNameToken, $package);
                break;
            case str_ends_with($token->getValue(), '-up|>'):
            case str_ends_with($token->getValue(), '-down|>'):
            case str_ends_with($token->getValue(), '-left|>'):
            case str_ends_with($token->getValue(), '-right|>'):
            case str_ends_with($token->getValue(), '-|>'):
                $childNameToken  = $this->lexer->prevElementValueToken();
                $parentNameToken = $this->lexer->nextElementValueToken();

                $this->parseExtends($childNameToken, $parentNameToken, $package);
                break;
            case str_ends_with($token->getValue(), '->'):
            case str_ends_with($token->getValue(), '.>'):
            case str_ends_with($token->getValue(), '-o'):
            case str_ends_with($token->getValue(), '.o'):
            case str_ends_with($token->getValue(), '-*'):
            case str_ends_with($token->getValue(), '.*'):
//                fwrite(STDOUT, sprintf("Skip parsing of '%s'. Still no support.\n", $token->getValue()));
                break;
        }
    }

    /**
     * @param ElementValueToken $childNameToken
     * @param string $package
     * @return Node
     */
    private function createUndefinedClass(ElementValueToken $childNameToken, string $package): Node
    {
        $this->parseClassLike(new ClassToken(), $childNameToken, $package);

        return $this->nodes->last();
    }

    private function postProcessing(): Nodes
    {
        $nodes = $this->deepCopy($this->nodes);

        $this->initializeNodes();
        $this->initializeLexer();

        return $nodes;
    }

    private function deepCopy(Nodes $nodes): Nodes
    {
        return unserialize(serialize($nodes));
    }

    private function initializeNodes(): void
    {
        $this->nodes = Nodes::empty();
    }

    private function initializeLexer(): void
    {
        $this->lexer = new Lexer('');
    }
}
