<?php


namespace PumlParser\Node;


class Interface_ implements Node
{
    public function toArray(): array
    {
        return [
            'Interface' => [
                'Name' => 'PumlTokenizer',
                'Package' => 'Lexer/Arrow',
                'Parents' => [],
                'Interfaces' => []
            ]
        ];
    }
}