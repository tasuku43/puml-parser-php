<?php
declare(strict_types=1);

namespace PumlParser\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Parser\Parser;

class ParserTest extends TestCase
{
    public function testParse(): void
    {
        $parser = new Parser(Lexer::fromSourceFile(__DIR__ . '/test.puml'));
        $ast    = $parser->parse();

        self::assertSame([
            [
                'interface' => [
                    'Name' => 'Tokenizeable',
                    'Package' => 'Lexer',
                    'Parents' => [],
                    'Interfaces' => []
                ]
            ],
            [
                'abstract class' => [
                    'Name' => 'ArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => [
                    'Name' => 'LeftArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'ArrowTokenizer',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Parents' => [],
                                            'Interfaces' => [],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                    'Interfaces' => []
                ]
            ],
            [
                'abstract class' => [
                    'Name' => 'CurlyBracketTokenizer',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => [
                    'Name' => 'OpenCurlyBracketToken',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'CurlyBracketTokenizer',
                                'Package' => 'Lexer/CurlyBracket',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Parents' => [],
                                            'Interfaces' => []
                                        ]
                                    ]
                                ]
                            ]
                        ],
                    ],
                    'Interfaces' => []
                ]
            ]
        ], $ast->toArray());
    }
}
