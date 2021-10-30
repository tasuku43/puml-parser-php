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
    public function testParseForward(string $contents, string $expected_className): void
    {

        $tokenizer = new PumlTokenizer();
        $token     = $tokenizer->parseForward($contents);

        self::assertInstanceOf($expected_className, $token);
        self::assertSame($token->getValue(), $contents);
    }

    public function dataProvider(): array
    {
        return [
            '<|up--' => [
                'expected_value' => '<|up--',
                'expected_className' => LeftArrowToken::class
            ],
            '<down--' => [
                'expected_value' => '<down--',
                'expected_className' => LeftArrowToken::class
            ],
            'o--' => [
                'expected_value' => 'o--',
                'expected_className' => LeftArrowToken::class
            ],
            '*left-' => [
                'expected_value' => '*left-',
                'expected_className' => LeftArrowToken::class
            ],
            '<-dow-' => [
                'expected_value' => '<-down-',
                'expected_className' => LeftArrowToken::class
            ],
            '<|up---------' => [
                'expected_value' => '<|up---------',
                'expected_className' => LeftArrowToken::class
            ],
            '<|up.' => [
                'expected_value' => '<|up.',
                'expected_className' => LeftArrowToken::class
            ],
            '<|-down-' => [
                'expected_value' => '<|-down-',
                'expected_className' => LeftArrowToken::class
            ],
            '--up|>' => [
                'expected_value' => '--up|>',
                'expected_className' => RightArrowToken::class
            ],
            '.up|>' => [
                'expected_value' => '.up|>',
                'expected_className' => RightArrowToken::class]
            ,
            '-left-|>' => [
                'expected_value' => '-left-|>',
                'expected_className' => RightArrowToken::class
            ],
            '------->' => [
                'expected_value' => '------->',
                'expected_className' => RightArrowToken::class
            ],
            '-right------>' => [
                'expected_value' => '-right------>',
                'expected_className' => RightArrowToken::class
            ]
        ];
    }

    /**
     * @dataProvider notArrowDataProviAder
     */
    public function testParseForwardNotArrow(string $contents, string $non_expected_className): void
    {

        $tokenizer = new PumlTokenizer();
        $token     = $tokenizer->parseForward($contents);

        self::assertNotInstanceOf($non_expected_className, $token);
    }

    public function notArrowDataProviAder(): array
    {
        return [
            'o' => [
                'contents' => 'o',
                'non_expected_className' => LeftArrowToken::class
            ],
            '*' => [
                'contents' => 'o',
                'non_expected_className' => LeftArrowToken::class
            ],

        ];
    }
}
