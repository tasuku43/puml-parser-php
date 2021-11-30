<?php
declare(strict_types=1);

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\PumlTokenizer;
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
use PumlParser\Lexer\Token\Visibility\PrivateVisibilityToken;
use PumlParser\Lexer\Token\Visibility\ProtectedVisibilityToken;
use PumlParser\Lexer\Token\Visibility\PublicVisibilityToken;
use PumlParser\Lexer\Token\Start\StartToken;
use PumlParser\Lexer\Token\Token;

class LexerTest extends TestCase
{
    public function testNext(): void
    {
        $lexer = new Lexer(new PumlTokenizer());
        $tokens = $lexer->startLexing(__DIR__ . '/test.puml');

        self::assertInstanceOf(StartToken::class, $tokens->current());

        $this->assertToken($tokens->next(), ClassToken::class, 'class');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Class');

        $this->assertToken($tokens->next(), OpenCurlyBracketToken::class, '{');

        $this->assertToken($tokens->next(), PublicVisibilityToken::class, '+');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'publicProperty');

        $this->assertToken($tokens->next(), ProtectedVisibilityToken::class, '#');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'protectedProperty');

        $this->assertToken($tokens->next(), PrivateVisibilityToken::class, '-');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'privateProperty');

        $this->assertToken($tokens->next(), CloseCurlyBracketToken::class, '}');

        $this->assertToken($tokens->next(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'AbstractClass');

        $this->assertToken($tokens->next(), InterfaceToken::class, 'interface');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Interface');

        $this->assertToken($tokens->next(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($tokens->next(), LeftArrowToken::class, '<|--');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Class');

        $this->assertToken($tokens->next(), ElementValueToken::class, 'AbstractClass');
        $this->assertToken($tokens->next(), RightArrowToken::class, '..|>');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Interface');

        $this->assertToken($tokens->next(), PackageToken::class, 'package');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Package');
        $this->assertToken($tokens->next(), OpenCurlyBracketToken::class, '{');

        $this->assertToken($tokens->next(), InterfaceToken::class, 'interface');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Interface2');

        $this->assertToken($tokens->next(), AbstractClassToken::class, 'abstract class');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'AbstractClass2');
        $this->assertToken($tokens->next(), ImplementsToken::class, 'implements');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Interface2');

        $this->assertToken($tokens->next(), ClassToken::class, 'class');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'Class2');
        $this->assertToken($tokens->next(), ExtendsToken::class, 'extends');
        $this->assertToken($tokens->next(), ElementValueToken::class, 'AbstractClass2');

        $this->assertToken($tokens->next(), CloseCurlyBracketToken::class, '}');

        self::assertInstanceOf(EndToken::class, $tokens->next());
    }

    private function assertToken(Token $token, string $class, string $value): void
    {
        self::assertInstanceOf($class, $token);
        self::assertSame($value, $token->getValue());
    }
}
