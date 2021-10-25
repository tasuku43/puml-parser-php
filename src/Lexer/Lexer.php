<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Token;

class Lexer
{
    use TokenizeSupport;

    public const PUML_START = '@startuml';
    public const PUML_END   = '@enduml';

    public const SKIP_STRINGS = [
        ' ',
        "\n",
        "\r",
        "\t"
    ];

    private int                   $length;
    private int                   $position;
    private PumlTokenizerResolver $tokenizerResolver;

    public function __construct(private string $contents)
    {
        $this->length            = strlen($contents);
        $this->position          = 0;
        $this->tokenizerResolver = new PumlTokenizerResolver();
    }

    public static function fromSourceFile(string $sourceFilePath): self
    {
        $file = file($sourceFilePath);

        // remove puml comment line.
        $contents_array = array_filter($file, function (string $line) {
            return !str_starts_with(ltrim($line), "'");
        });

        return new self(implode($contents_array));
    }

    public function getNextToken(): Token
    {
        while ($contents = $this->currentToEndContents()) {
            if ($start_string = $this->contentsStartsWith($contents, self::SKIP_STRINGS)) {
                $this->position += strlen($start_string);
                continue;
            }

            break;
        }

        $token = $this->tokenizerResolver->resolve($contents)->parseForward($contents);

        $this->position += strlen($token->getValue());

        return $token;
    }

    private function currentToEndContents(): ?string
    {
        return $this->subContents($this->length - $this->position);
    }

    private function subContents(int $length): ?string
    {
        if ($this->length <= $this->position) {
            return null;
        }

        return substr($this->contents, $this->position, $this->position + $length);
    }
}
