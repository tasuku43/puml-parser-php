<?php
declare(strict_types=1);

namespace PumlParser\Lexer\Token;

use PumlParser\Lexer\Token\ElementValue\ElementValueToken;

class Tokens
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

    public function next(string $tokenType = ''): self
    {
        if ($tokenType === '') {
            $this->position++;

            return $this;
        }

        do {
            $this->position++;
        } while (!$this->current() instanceof $tokenType or $this->current() === null);

        return $this;
    }

    public function nextElementValueToken(): ElementValueToken
    {
        $token = $this->next(ElementValueToken::class)->current();

        assert($token instanceof ElementValueToken);

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

    public function add(Token $token): self
    {
        $this->values[] = $token;

        return $this;
    }
}
