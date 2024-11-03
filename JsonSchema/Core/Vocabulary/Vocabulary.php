<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core\Vocabulary;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Core;

final readonly class Vocabulary implements Core
{
    private function __construct(
        private array $vocabs,
    ) {
    }

    public static function create(Vocal ...$value): self
    {
        return new self($value);
    }

    public static function keyword(): string
    {
        return '$vocabulary';
    }

    public function value(): array
    {
        return $this->vocabs;
    }
}
