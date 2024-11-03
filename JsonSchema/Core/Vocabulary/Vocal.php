<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core\Vocabulary;

final readonly class Vocal
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

    public function identifier(): string
    {
        return $this->id;
    }

    public function required(): bool
    {
        return $this->required;
    }
}
