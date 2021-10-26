<?php
declare(strict_types=1);

namespace PumlParser\Parser;

use PumlParser\Lexer\Lexer;
use PumlParser\Node\AbstractClass_;
use PumlParser\Node\Class_;
use PumlParser\Node\Interface_;
use PumlParser\Node\Nodes;

class Parser
{
    public function __construct(private Lexer $lexer)
    {
    }

    public function parse(): Nodes
    {
        $package = 'Lexer/Arrow';

        $interface = new Interface_('PumlTokenizer', $package);

        $abstractClass = new AbstractClass_('ArrowTokenizer', $package);
        $abstractClass->implements($interface);

        $class = new Class_('LeftArrowTokenizer', $package);
        $class->extends($abstractClass);

        return new Nodes($class, $abstractClass, $interface);
    }
}
