<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\Validations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use Webmozart\Assert\Assert;

final readonly class MaxLength implements Validation
{
    private function __construct(
        private int $value,
    ) {
    }

    public static function create(int $value): self
    {
        Assert::greaterThanEq($value, 0);

        return new self($value);
    }

    public static function keyword(): string
    {
        return 'maxLength';
    }

    public function value(): int
    {
        return $this->value;
    }
}
