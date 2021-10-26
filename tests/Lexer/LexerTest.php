<?php
declare(strict_types=1);

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
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
use PumlParser\Lexer\Token\Extends\ExtendsToken;
use PumlParser\Lexer\Token\Implements\ImplementsToken;
use PumlParser\Lexer\Token\Start\StartToken;
use PumlParser\Lexer\Token\Token;

class LexerTest extends TestCase
{
    public function testGetNextToken(): void
    {
        $lexer = Lexer::fromSourceFile(__DIR__ . '/test.puml');

        self::assertInstanceOf(StartToken::class, $lexer->getNextToken());

        $this->assertToken($lexer->getNextToken(), ClassToken::class, 'class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->getNextToken(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');

        $this->assertToken($lexer->getNextToken(), InterfaceToken::class, 'interface');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->getNextToken(), LeftArrowToken::class, '<|--');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->getNextToken(), RightArrowToken::class, '..|>');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->getNextToken(), PackageToken::class, 'package');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Package');
        $this->assertToken($lexer->getNextToken(), OpenCurlyBracketToken::class, '{');

        $this->assertToken($lexer->getNextToken(), InterfaceToken::class, 'interface');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface2');

        $this->assertToken($lexer->getNextToken(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass2');
        $this->assertToken($lexer->getNextToken(), ImplementsToken::class, 'implements');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Interface2');

        $this->assertToken($lexer->getNextToken(), ClassToken::class, 'class');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'Class2');
        $this->assertToken($lexer->getNextToken(), ExtendsToken::class, 'extends');
        $this->assertToken($lexer->getNextToken(), ElementValueToken::class, 'AbstractClass2');

        $this->assertToken($lexer->getNextToken(), CloseCurlyBracketToken::class, '}');

        self::assertInstanceOf(EndToken::class, $lexer->getNextToken());
    }

    private function assertToken(Token $token, string $class, string $value): void
    {
        self::assertInstanceOf($class, $token);
        self::assertSame($value, $token->getValue());
    }
}
