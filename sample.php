<?php

require_once __DIR__ . '/vendor/autoload.php';

use PumlParser\Lexer\Lexer;
use PumlParser\Lexer\PumlTokenizer;
use PumlParser\Parser\Parser;

$lexer       = new Lexer(new PumlTokenizer());
$parser      = new Parser($lexer);
$ast         = $parser->parse(__DIR__ . '/sample.puml');

foreach ($ast->toDtos() as $definition) {
    echo "----------\n";

    echo "name: " . $definition->getName() . "\n";
    echo "package: " . $definition->getPackage() . "\n";

    if ($definition->getType() === 'enum') {
        foreach ($definition->getCases() as $case) {
            echo "case: " . $case . "\n";
        }
    } else {
        foreach ($definition->getProperties() as $property) {
            $propertyResult = "property name: " . $property->getName();
            $propertyResult .= " , visibility:  " . $property->getVisibility();
            $propertyResult .= " , type:  " . $property->getType();
            echo $propertyResult . "\n";
        }
    }
}

//var_dump($ast->toDtos());
//echo $ast->toJson();
//var_dump($ast->toArray());
