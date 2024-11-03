<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Core;

final readonly class Anchor implements Core
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public static function keyword(): string
    {
        return '$anchor';
    }

    public function value(): string
    {
        return $this->value;
    }
}
