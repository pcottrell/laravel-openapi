<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocab;

final readonly class Vocabulary implements Keyword
{
    private function __construct(
        private array $vocabs,
    ) {
    }

    public static function create(Vocab ...$value): self
    {
        return new self($value);
    }

    public static function name(): string
    {
        return '$vocabulary';
    }

    public function value(): array
    {
        return $this->vocabs;
    }
}
