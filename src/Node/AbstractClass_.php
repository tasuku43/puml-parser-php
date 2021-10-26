<?php
declare(strict_types=1);

namespace PumlParser\Node;

class AbstractClass_ implements Node
{
    public function toArray(): array
    {
        return [
            'AbstractClass' => [
                'Name' => 'ArrowTokenizer',
                'Package' => 'Lexer/Arrow',
                'Parents' => '',
                'Interfaces' => [
                    'Interface' => [
                        'Name' => 'PumlTokenizer',
                        'Package' => 'Lexer/Arrow',
                        'Parents' => [],
                        'Interfaces' => []
                    ]
                ]
            ]
        ];
    }
}