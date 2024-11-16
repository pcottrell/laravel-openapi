<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class DefaultValue implements Keyword
{
    private function __construct(
        private mixed $value,
    ) {
    }

    public static function create(mixed $value): self
    {
        return new self($value);
    }

    public static function name(): string
    {
        return 'default';
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
