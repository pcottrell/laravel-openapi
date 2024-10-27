<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\MetaData;

final readonly class Examples implements MetaData
{
    private function __construct(
        private array $examples,
    ) {
    }

    public static function create(mixed ...$example): self
    {
        return new self($example);
    }

    public static function keyword(): string
    {
        return 'examples';
    }

    public function value(): array
    {
        return $this->examples;
    }
}
