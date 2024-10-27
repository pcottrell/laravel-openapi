<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use Webmozart\Assert\Assert;

final readonly class MinProperties implements Validation
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
        return 'minProperties';
    }

    public function value(): int
    {
        return $this->value;
    }
}
