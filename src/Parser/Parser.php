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
        return new Nodes(new Class_(), new AbstractClass_(), new Interface_());
    }
}
