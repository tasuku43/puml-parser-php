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
use PumlParser\Lexer\Token\Element\ElementToken;
use PumlParser\Lexer\Token\Element\EnumToken;
use PumlParser\Lexer\Token\Element\InterfaceToken;
use PumlParser\Lexer\Token\Element\PackageToken;
use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\End\EndToken;
use PumlParser\Lexer\Token\Exception\TokenizeException;
use PumlParser\Lexer\Token\Extends\ExtendsToken;
use PumlParser\Lexer\Token\Implements\ImplementsToken;
use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\Tokens;
use PumlParser\Lexer\Token\Visibility\VisibilityToken;
use PumlParser\Node\AbstractClass_;
use PumlParser\Node\Class_;
use PumlParser\Node\Enum_;
use PumlParser\Node\Interface_;
use PumlParser\Node\Node;
use PumlParser\Node\Nodes;
use PumlParser\Node\Property;
use PumlParser\Parser\Exception\ParserException;

class Parser
{
    private Nodes  $nodes;
    private Tokens $tokens;

    public function __construct(private Lexer $lexer)
    {
        $this->initializeNodes();
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
     */
    public function parse(string $pumlFilePath): Nodes
    {
        $this->tokens = $this->lexer->startLexing($pumlFilePath);

        while (!$this->tokens->next() instanceof EndToken) {
            $this->parseToken($this->tokens->current());
        }

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
                $packageNameToken = $this->tokens->nextElementValueToken();

                $this->parseInPackage($packageNameToken);
                break;
            case $token instanceof ClassToken || $token instanceof AbstractClassToken || $token instanceof InterfaceToken || $token instanceof EnumToken:
                $classLikeNameToken = $this->tokens->nextElementValueToken();

                $this->parseClassLike($token, $classLikeNameToken, $package);
                break;
            case $token instanceof LeftArrowToken:
                $leftToken = $this->tokens->getPrevToken();
                assert($leftToken instanceof ElementValueToken);

                $rightToken = $this->tokens->nextElementValueToken();

                $this->parseLeftArrow($token, $leftToken, $rightToken, $package);
                break;
            case $token instanceof RightArrowToken:
                $leftToken = $this->tokens->getPrevToken();
                assert($leftToken instanceof ElementValueToken);

                $rightToken = $this->tokens->nextElementValueToken();

                $this->parseRightArrow($token, $leftToken, $rightToken, $package);
                break;
        }
    }

    /**
     * @throws ParserException
     * @throws TokenizeException
     */
    private function parseInPackage(ElementValueToken $token): void
    {
        $package = $token->getValue();
        $depth   = 0;

        do {
            $token = $this->tokens->next();

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
        ElementToken $elementToken,
        ElementValueToken $nameToken,
        string $package = ''
    ): void
    {
        $node = match (true) {
            $elementToken instanceof ClassToken => new Class_($nameToken->getValue(), $package),
            $elementToken instanceof AbstractClassToken => new AbstractClass_($nameToken->getValue(), $package),
            $elementToken instanceof InterfaceToken => new Interface_($nameToken->getValue(), $package),
            $elementToken instanceof EnumToken => new Enum_($nameToken->getValue(), $package),
        };

        $this->nodes->add($node);

        if ($this->tokens->nextTokenTypeIs(ExtendsToken::class)) {
            $parentNameToken = $this->tokens->nextElementValueToken();

            $this->parseExtends($nameToken, $parentNameToken, $package);
        }
        if ($this->tokens->nextTokenTypeIs(ImplementsToken::class)) {
            $parentNameToken = $this->tokens->nextElementValueToken();

            $this->parseImplements($nameToken, $parentNameToken, $package);
        }

        if ($this->tokens->nextTokenTypeIs(OpenCurlyBracketToken::class)) {
            $this->tokens->next();

            while (!$this->tokens->next() instanceof CloseCurlyBracketToken) {
                if ($node instanceof Enum_) {
                    $caseToken = $this->tokens->current();

                    $node->addCases($caseToken->getValue());
                } else {
                    $visibilityToken = $this->tokens->current() instanceof VisibilityToken
                        ? $this->tokens->current()
                        : $this->tokens->nextVisibilityToken();

                    $propertyNameToken = $this->tokens->nextElementValueToken();

                    $node->addProperty(new Property($propertyNameToken->getValue(), (string)$visibilityToken));
                }
            }
        }
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

    private function parseLeftArrow(
        LeftArrowToken $token,
        ElementValueToken $leftToken,
        ElementValueToken $rightToken,
        string $package = ''
    ): void
    {
        switch (true) {
            case str_starts_with($token->getValue(), '<|up.'):
            case str_starts_with($token->getValue(), '<|.up'):
            case str_starts_with($token->getValue(), '<|down.'):
            case str_starts_with($token->getValue(), '<|.down'):
            case str_starts_with($token->getValue(), '<|left.'):
            case str_starts_with($token->getValue(), '<|.left'):
            case str_starts_with($token->getValue(), '<|right.'):
            case str_starts_with($token->getValue(), '<|.right'):
            case str_starts_with($token->getValue(), '<|.'):
                $this->parseImplements($rightToken, $leftToken, $package);
                break;
            case str_starts_with($token->getValue(), '<|up-'):
            case str_starts_with($token->getValue(), '<|-up'):
            case str_starts_with($token->getValue(), '<|down-'):
            case str_starts_with($token->getValue(), '<|-down'):
            case str_starts_with($token->getValue(), '<|left-'):
            case str_starts_with($token->getValue(), '<|-left'):
            case str_starts_with($token->getValue(), '<|right-'):
            case str_starts_with($token->getValue(), '<|-right'):
            case str_starts_with($token->getValue(), '<|-'):
                $this->parseExtends($rightToken, $leftToken, $package);
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

    private function parseRightArrow(
        RightArrowToken $token,
        ElementValueToken $leftToken,
        ElementValueToken $rightToken,
        string $package = ''
    ): void
    {
        switch (true) {
            case str_ends_with($token->getValue(), '.up|>'):
            case str_ends_with($token->getValue(), 'up.|>'):
            case str_ends_with($token->getValue(), '.down|>'):
            case str_ends_with($token->getValue(), 'down.|>'):
            case str_ends_with($token->getValue(), '.left|>'):
            case str_ends_with($token->getValue(), 'left.|>'):
            case str_ends_with($token->getValue(), '.right|>'):
            case str_ends_with($token->getValue(), 'right.|>'):
            case str_ends_with($token->getValue(), '.|>'):
                $this->parseImplements($leftToken, $rightToken, $package);
                break;
            case str_ends_with($token->getValue(), '-up|>'):
            case str_ends_with($token->getValue(), 'up-|>'):
            case str_ends_with($token->getValue(), '-down|>'):
            case str_ends_with($token->getValue(), 'down-|>'):
            case str_ends_with($token->getValue(), '-left|>'):
            case str_ends_with($token->getValue(), 'left-|>'):
            case str_ends_with($token->getValue(), '-right|>'):
            case str_ends_with($token->getValue(), 'right-|>'):
            case str_ends_with($token->getValue(), '-|>'):
                $this->parseExtends($leftToken, $rightToken, $package);
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
}
