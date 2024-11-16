<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary;

final readonly class Vocab
{
    private function __construct(
        private string $id,
        private bool $required,
    ) {
    }

    public static function create(string $id, bool $required): self
    {
        return new self($id, $required);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function required(): bool
    {
        return $this->required;
    }
}
