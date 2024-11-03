<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Core;

final readonly class DynamicAnchor implements Core
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
        return '$dynamicAnchor';
    }

    public function value(): string
    {
        return $this->value;
    }
}
