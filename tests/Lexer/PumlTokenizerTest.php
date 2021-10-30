<?php

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Lexer\Token\Arrow\LeftArrowToken;
use PumlParser\Lexer\Token\Arrow\RightArrowToken;

class PumlTokenizerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testParseForward(string $expected, string $class): void
    {

        $tokenizer = new PumlTokenizer();
        $token     = $tokenizer->parseForward($expected);

        self::assertInstanceOf($class, $token);
        self::assertSame($token->getValue(), $expected);
    }

    public function dataProvider(): array
    {
        return [
            '<|up--' => [
                'expected' => '<|up--',
                'className' => LeftArrowToken::class
            ],
            '<down--' => [
                'expected' => '<down--',
                'className' => LeftArrowToken::class
            ],
            '<-dow-' => [
                'expected' => '<-down-',
                'className' => LeftArrowToken::class
            ],
            '<|up---------' => [
                'expected' => '<|up---------',
                'className' => LeftArrowToken::class
            ],
            '<|up.' => [
                'expected' => '<|up.',
                'className' => LeftArrowToken::class
            ],
            '<|-down-' => [
                'expected' => '<|-down-',
                'className' => LeftArrowToken::class
            ],
            '--up|>' => [
                'expected' => '--up|>',
                'className' => RightArrowToken::class
            ],
            '.up|>' => [
                'expected' => '.up|>',
                'className' => RightArrowToken::class]
            ,
            '-left-|>' => [
                'expected' => '-left-|>',
                'className' => RightArrowToken::class
            ],
            '------->' => [
                'expected' => '------->',
                'className' => RightArrowToken::class
            ],
            '-right------>' => [
                'expected' => '-right------>',
                'className' => RightArrowToken::class
            ]
        ];
    }
}
