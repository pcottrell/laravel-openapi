<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class ConstantDescriptor extends Generatable implements SchemaProperty, Validation, Descriptor, TypeAware
{
    private mixed $value;

    // TODO: It would be cool if constants could accept Schema types
    public static function create($value): self
    {
        $clone = new self();

        $clone->value = $value;

        return $clone;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function is(string $type): bool
    {
        return $type === self::keyword();
    }

    public static function keyword(): string
    {
        return 'const';
    }

    protected function toArray(): array
    {
        return [
            self::keyword() => $this->value,
        ];
    }
}
