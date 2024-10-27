<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\MetaData;

final readonly class DefaultValue implements MetaData
{
    private function __construct(
        private mixed $value,
    ) {
    }

    public static function create(mixed $value): self
    {
        return new self($value);
    }

    public static function keyword(): string
    {
        return 'default';
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
