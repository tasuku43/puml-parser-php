<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

use PumlParser\Lexer\Token\ElementValue\ElementValueToken;
use PumlParser\Lexer\Token\Visibility\VisibilityToken;

class Tokens implements \Iterator
{
    /**
     * @var Token[]
     */
    private array $values;

    private int $position = 0;

    public function current(): ?Token
    {
        return $this->values[$this->position] ?? null;
    }

    public function next(): ?Token
    {
        $this->position++;

        return $this->current();
    }

    public function nextTo(string $tokenType): Token
    {
        while (($token = $this->next()) !== null) {
            if ($token instanceof $tokenType) return $token;
        }

        throw new \InvalidArgumentException();
    }

    public function nextElementValueToken(): ElementValueToken
    {
        $token = $this->nextTo(ElementValueToken::class);

        assert($token instanceof ElementValueToken);

        return $token;
    }

    public function nextVisibilityToken(): VisibilityToken
    {
        $token = $this->nextTo(VisibilityToken::class);

        assert($token instanceof VisibilityToken);

        return $token;
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
