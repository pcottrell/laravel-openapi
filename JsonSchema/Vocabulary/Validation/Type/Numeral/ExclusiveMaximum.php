<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Numeral;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class ExclusiveMaximum implements SchemaProperty, Validation
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
        return 'exclusiveMaximum';
    }

    public function value(): float
    {
        return $this->value;
    }
}