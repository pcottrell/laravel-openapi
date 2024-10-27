<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class Required implements Validation
{
    private function __construct(
        private array $properties,
    ) {
    }

    public static function create(string ...$property): self
    {
        return new self($property);
    }

    public static function keyword(): string
    {
        return 'required';
    }

    public function value(): array
    {
        return $this->properties;
    }
}
