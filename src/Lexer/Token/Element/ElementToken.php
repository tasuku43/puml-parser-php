<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token\Element;

use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\TokenSupport;

abstract class ElementToken implements Token
{
    public const CLASS_          = 'class';
    public const ABSTRACT_CLASS_ = 'abstract class';
    public const ABSTRACT_       = 'abstract';
    public const INTERFACE_      = 'interface';
    public const PACKAGE_        = 'package';
    public const NAMESPACE_      = 'namespace';
    public const ENUM_           = 'enum';
    public const ENTITY_         = 'entity';
    public const CIRCLE_         = 'circle';
    public const DIAMOND_        = 'diamond';
    public const ANNOTATION_     = 'annotation';

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
