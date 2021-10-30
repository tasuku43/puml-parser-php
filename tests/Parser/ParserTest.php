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
        $parser = new Parser(Lexer::fromSourceFile(__DIR__ . '/test.puml'));
        $ast    = $parser->parse();

        self::assertSame([
            [
                'Interface' => [
                    'Name' => 'Tokenizeable',
                    'Package' => 'Lexer',
                    'Parents' => [],
                    'Interfaces' => []
                ]
            ],
            [
                'AbstractClass' => [
                    'Name' => 'ArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'Interface' => [
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
                'Class' => [
                    'Name' => 'LeftArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Parents' => [
                        [
                            'AbstractClass' => [
                                'Name' => 'ArrowTokenizer',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'Interface' => [
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
                'AbstractClass' => [
                    'Name' => 'CurlyBracketTokenizer',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'Interface' => [
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
                'Class' => [
                    'Name' => 'OpenCurlyBracketToken',
                    'Package' => 'Lexer/CurlyBracket',
                    'Parents' => [
                        [
                            'AbstractClass' => [
                                'Name' => 'CurlyBracketTokenizer',
                                'Package' => 'Lexer/CurlyBracket',
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'Interface' => [
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
