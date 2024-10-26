<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class Maximum implements SchemaProperty, Validation
{
    private function __construct(
        private float $value,
    ) {
    }

    public static function create(float $value): self
    {
        return new self($value);
    }

    public static function keyword(): string
    {
        return 'maximum';
    }

    public function value(): float
    {
        return $this->value;
    }
}