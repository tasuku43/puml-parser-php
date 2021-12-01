<?php
declare(strict_types=1);

namespace PumlParser\Tests\Parser;

use PHPUnit\Framework\TestCase;
use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Parser\Parser;

class ParserTest extends TestCase
{
    public function testParse(): void
    {
        $lexer  = new Lexer(new PumlTokenizer());
        $parser = new Parser($lexer);
        $ast    = $parser->parse(__DIR__ . '/test.puml');

        self::assertSame([
            [
                'interface' => [
                    'Name' => 'Tokenizeable',
                    'Package' => 'Lexer',
                    'Propaties' => [],
                    'Parents' => [],
                    'Interfaces' => []
                ]
            ],
            [
                'abstract class' => [
                    'Name' => 'ArrowTokenizer',
                    'Package' => 'Lexer/Arrow',
                    'Propaties' => [],
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Propaties' => [],
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
                    'Propaties' => [
                        [
                            'name' => 'publicProperty',
                            'visibility' => 'public',
                        ],
                        [
                            'name' => 'protectedProperty',
                            'visibility' => 'protected',
                        ],
                        [
                            'name' => 'privateProperty',
                            'visibility' => 'private',
                        ],
                    ],
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'ArrowTokenizer',
                                'Package' => 'Lexer/Arrow',
                                'Propaties' => [],
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Propaties' => [],
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
                    'Propaties' => [],
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Propaties' => [],
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
                    'Propaties' => [],
                    'Parents' => [
                        [
                            'abstract class' => [
                                'Name' => 'CurlyBracketTokenizer',
                                'Package' => 'Lexer/CurlyBracket',
                                'Propaties' => [],
                                'Parents' => [],
                                'Interfaces' => [
                                    [
                                        'interface' => [
                                            'Name' => 'Tokenizeable',
                                            'Package' => 'Lexer',
                                            'Propaties' => [],
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
            ],
            [
                'class' => [
                    'Name' => 'NoneDefinitionClass',
                    'Package' => 'Lexer',
                    'Propaties' => [],
                    'Parents' => [],
                    'Interfaces' => [
                        [
                            'interface' => [
                                'Name' => 'Tokenizeable',
                                'Package' => 'Lexer',
                                'Propaties' => [],
                                'Parents' => [],
                                'Interfaces' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'enum' => [
                    'Name' => 'Enum',
                    'Package' => '',
                    'Types' => [
                        'TYPE1',
                        'TYPE2',
                        'TYPE3',
                    ],
                    'Parents' => [],
                    'Interfaces' => []
                ]
            ]
        ], $ast->toArray());
    }
}
