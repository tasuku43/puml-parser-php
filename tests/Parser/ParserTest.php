<?php
declare(strict_types=1);

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Node\Node;
use PumlParser\Parser\Parser;

class ParserTest extends TestCase
{
    public function testParse(): void
    {
        $parser = new Parser(Lexer::fromSourceFile(__DIR__ . '/../test.puml'));
        $ast    = $parser->parse();

        self::assertInstanceOf(Node::class, $ast);

        self::assertSame([
            'LeftArrowTokenizer' => [
                'Type' => 'Class',
                'Package' => 'Lexer/Arrow',
                'Parents' => [
                    'ArrowTokenizer' => [
                        'Type' => 'AbstractClass',
                        'Package' => 'Lexer/Arrow',
                        'Parents' => [],
                        'Interfaces' => [
                            'PumlTokenizer' => [
                                'Type' => 'Interface',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [],
                            ],
                        ],
                    ],
                ],
                'Interfaces' => [],
            ],
            'RightArrowTokenizer' => [
                'Type' => 'Class',
                'Package' => 'Lexer/Arrow',
                'Parents' => [
                    'ArrowTokenizer' => [
                        'Type' => 'AbstractClass',
                        'Package' => 'Lexer/Arrow',
                        'Parents' => [],
                        'Interfaces' => [
                            'PumlTokenizer' => [
                                'Type' => 'Interface',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [],
                            ],
                        ],
                    ],
                ],
                'Interfaces' => [],
            ],
            'ArrowTokenizer' => [
                'Type' => 'AbstractClass',
                'Package' => 'Lexer/Arrow',
                'Parents' => '',
                'Interfaces' => [
                    'PumlTokenizer' => [
                        'Type' => 'Interface',
                        'Package' => 'Lexer/Arrow',
                        'Parents' => [],
                        'Interfaces' => [],
                    ],
                ],
            ],
            'PumlTokenizer' => [
                'Type' => 'Interface',
                'Package' => 'Lexer/Arrow',
                'Parents' => [],
                'Interfaces' => [],
            ],
        ], $ast->toArray());
    }
}
