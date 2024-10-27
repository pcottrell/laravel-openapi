<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\MetaData;

final readonly class Description implements MetaData
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
        return 'description';
    }

    public function value(): string
    {
        return $this->value;
    }
}
