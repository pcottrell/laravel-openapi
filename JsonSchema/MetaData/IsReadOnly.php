<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\MetaData;

final readonly class IsReadOnly implements SchemaProperty, MetaData
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
        return 'readOnly';
    }

    public function value(): bool
    {
        return $this->value;
    }
}
