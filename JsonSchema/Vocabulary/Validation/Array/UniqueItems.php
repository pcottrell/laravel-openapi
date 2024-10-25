<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Array;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class UniqueItems implements SchemaProperty, Validation
{
    private function __construct(
        private bool $value,
    ) {
    }

    public static function create(bool $value): self
    {
        return new self($value);
    }

    public static function keyword(): string
    {
        return 'uniqueItems';
    }

    public function value(): bool
    {
        return $this->value;
    }
}
