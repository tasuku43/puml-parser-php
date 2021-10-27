<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\Element\ElementToken;
use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\Exception\TokenException;
use PumlParser\Lexer\Token\Token;

class Lexer
{
    use TokenizeSupport;

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

    /**
     * @throws TokenException
     */
    public function getNextElementToken(): ElementToken
    {
        $token = $this->getNextToken();

        if ($token instanceof ElementToken) {
            return $token;
        }

        throw new TokenException();
    }

    /**
     * @throws TokenException
     */
    public function getNextElementValueToken(): ElementValueToken
    {
        $token = $this->getNextToken();

        if ($token instanceof ElementValueToken) {
            return $token;
        }

        throw new TokenException();
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
