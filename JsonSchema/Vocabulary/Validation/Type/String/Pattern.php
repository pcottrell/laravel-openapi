<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\String;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class Pattern implements SchemaProperty, Validation
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
        return 'pattern';
    }

    public function value(): string
    {
        return $this->value;
    }
}
