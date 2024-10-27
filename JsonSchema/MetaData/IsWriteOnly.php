<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\MetaData;

final readonly class IsWriteOnly implements MetaData
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
        return 'writeOnly';
    }

    public function value(): bool
    {
        return $this->value;
    }
}
