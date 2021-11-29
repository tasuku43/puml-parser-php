<?php
declare(strict_types=1);

namespace PumlParser\Lexer;

use PumlParser\Lexer\Token\End\EndToken;
use PumlParser\Lexer\Token\Token;
use PumlParser\Lexer\Token\Tokens;

class Lexer
{
    use TokenizeSupport;

    public const SKIP_STRINGS = [
        ' ',
        "\n",
        "\r",
        "\t"
    ];

    private int    $length   = 0;
    private int    $position = 0;
    private string $contents = '';

    public function __construct(private PumlTokenizer $tokenizer)
    {
    }

    public function startLexing(string $sourceFilePath): Tokens
    {
        $this->initialize($sourceFilePath);

        $tokens = new Tokens();

        do {
            $token = $this->next();

            $tokens->add($token);
        } while (!$token instanceof EndToken);

        $this->reflesh();

        return $tokens;
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

    private function initialize(string $sourceFilePath): void
    {
        $file = file($sourceFilePath);

        // remove puml comment line.
        $contents_array = array_filter($file, function (string $line) {
            return !str_starts_with(ltrim($line), "'");
        });

        $this->contents = implode($contents_array);
        $this->length   = strlen($this->contents);
        $this->position = 0;
    }

    public function reflesh(): void
    {
        $this->length   = 0;
        $this->position = 0;
        $this->contents = '';
    }
}
