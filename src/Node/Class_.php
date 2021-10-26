<?php
declare(strict_types=1);

namespace PumlParser\Node;

class Class_ implements Node
{
    public function toArray(): array
    {
        return [
            'Class' => [
                'Name' => 'LeftArrowTokenizer',
                'Package' => 'Lexer/Arrow',
                'Parents' => [
                    'AbstractClass' => [
                        'Name' => 'ArrowTokenizer',
                        'Package' => 'Lexer/Arrow',
                        'Parents' => [],
                        'Interfaces' => [
                            'Interface' => [
                                'Neme' => 'PumlTokenizer',
                                'Package' => 'Lexer/Arrow',
                                'Parents' => [],
                                'Interfaces' => [],
                            ]
                        ]
                    ]
                ],
                'Interfaces' => []
            ]
        ];
    }
}