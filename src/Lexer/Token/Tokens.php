<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

class Tokens implements \Iterator
{
    /**
     * @var Token[]
     */
    private array $values;

    private int $position = 0;

    public function current(): Token
    {
        return $this->values[$this->position];
    }

    public function next(): Token
    {
        $this->position++;

        return $this->current();
    }

    public function getPrevToken(int $backStepNum = 1): Token
    {
        return $this->values[$this->position - $backStepNum];
    }

    public function getNextToken(int $nextStepNum = 1): Token
    {
        return $this->values[$this->position + $nextStepNum];
    }

    public function nextTokenTypeIs(string $tokenType): bool
    {
        return $this->getNextToken()::class === $tokenType;
    }

    public function add(Token $token): self
    {
        $this->values[] = $token;

        return $this;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->values[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
