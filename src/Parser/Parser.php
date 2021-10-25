<?php
declare(strict_types=1);

namespace PumlParser\Parser;

use PumlParser\Lexer\Lexer;
use PumlParser\Node\Node;

class Parser
{
    public function __construct(private Lexer $lexer)
    {
    }

    public function parse(): Node
    {
    }
}
