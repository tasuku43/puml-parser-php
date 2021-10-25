<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

class ElementToken implements Token
{
    use TokenSupport;

    private const CLASS_          = 'class';
    private const ABSTRACT_CLASS_ = 'abstract class';
    private const ABSTRACT_       = 'abstract';
    private const INTERFACE_      = 'interface';
    private const PACKAGE_        = 'package';
    private const NAMESPACE_      = 'namespace';
    private const ENUM_           = 'enum';
    private const ENTITY_         = 'entity';
    private const CIRCLE_         = 'circle';
    private const DIAMOND_        = 'diamond';
    private const ANNOTATION_     = 'annotation';

    /**
     * @return string[]
     */
    public static function symbols(): array
    {
        return [
            self::CLASS_,
            self::ABSTRACT_CLASS_,
            self::ABSTRACT_,
            self::INTERFACE_,
            self::PACKAGE_,
            self::NAMESPACE_,
            self::ENUM_,
            self::ENTITY_,
            self::CIRCLE_,
            self::DIAMOND_,
            self::ANNOTATION_
        ];
    }
}
