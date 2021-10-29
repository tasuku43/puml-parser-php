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

        self::assertInstanceOf(StartToken::class, $lexer->next());

        $this->assertToken($lexer->next(), ClassToken::class, 'class');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->next(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'AbstractClass');

        $this->assertToken($lexer->next(), InterfaceToken::class, 'interface');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->next(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->next(), LeftArrowToken::class, '<|--');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Class');

        $this->assertToken($lexer->next(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($lexer->next(), RightArrowToken::class, '..|>');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Interface');

        $this->assertToken($lexer->next(), PackageToken::class, 'package');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Package');
        $this->assertToken($lexer->next(), OpenCurlyBracketToken::class, '{');

        $this->assertToken($lexer->next(), InterfaceToken::class, 'interface');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Interface2');

        $this->assertToken($lexer->next(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'AbstractClass2');
        $this->assertToken($lexer->next(), ImplementsToken::class, 'implements');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Interface2');

        $this->assertToken($lexer->next(), ClassToken::class, 'class');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'Class2');
        $this->assertToken($lexer->next(), ExtendsToken::class, 'extends');
        $this->assertToken($lexer->next(), ElementValueToken::class, 'AbstractClass2');

        $this->assertToken($lexer->next(), CloseCurlyBracketToken::class, '}');

        self::assertInstanceOf(EndToken::class, $lexer->next());
    }

    private function assertToken(Token $token, string $class, string $value): void
    {
        self::assertInstanceOf($class, $token);
        self::assertSame($value, $token->getValue());
    }
}
