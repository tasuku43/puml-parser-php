<?php

require_once __DIR__ . '/vendor/autoload.php';

use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Parser\Parser;

$lexer       = new Lexer(new PumlTokenizer());
$parser      = new Parser($lexer);
$ast         = $parser->parse(__DIR__ . '/sample.puml');

foreach ($ast->toDtos() as $difinition) {
    echo "----------\n";

    echo "name: " . $difinition->getName() . "\n";
    echo "package: " . $difinition->getPackage() . "\n";

    foreach ($difinition->getProperties() as $property) {
        echo "property name: " . $property->getName() . " , visibility:  " . $property->getVisibility() . "\n";
    }
}

//var_dump($ast->toDtos());
//echo $ast->toJson();
//var_dump($ast->toArray());
