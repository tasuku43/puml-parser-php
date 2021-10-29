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

    private int           $length;
    private int           $position;
    private PumlTokenizer $tokenizer;
    private array         $history = [];

    public function __construct(private string $contents)
    {
        $this->length    = strlen($contents);
        $this->position  = 0;
        $this->tokenizer = new PumlTokenizer();
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

    public function prev(int $backStepNum = 1): Token
    {
        return $this->history[array_key_last($this->history) - $backStepNum];
    }

    public function current(): Token
    {
        return $this->history[array_key_last($this->history)];
    }

    public function next(): Token
    {
        while ($contents = $this->currentToEndContents()) {
            if ($start_string = $this->contentsStartsWith($contents, self::SKIP_STRINGS)) {
                $this->position += strlen($start_string);
                continue;
            }

            break;
        }

        $token = $this->tokenizer->parseForward($contents);

        $this->position += strlen($token->getValue());

        return $this->history[] = $token;
    }

    /**
     * @throws TokenException
     */
    public function nextElementToken(): ElementToken
    {
        $token = $this->next();

        if ($token instanceof ElementToken) {
            return $token;
        }

        throw new TokenException();
    }

    /**
     * @throws TokenException
     */
    public function nextElementValueToken(): ElementValueToken
    {
        $token = $this->next();

        if ($token instanceof ElementValueToken) {
            return $token;
        }

        throw new TokenException();
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
