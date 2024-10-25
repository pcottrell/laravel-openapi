<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class Constant extends Generatable implements SchemaProperty, Validation
{
    private mixed $value;

    // TODO: It would be cool if constants could accept Schema types
    public static function create($value): self
    {
        $clone = new self();

        $clone->value = $value;

        return $clone;
    }

    protected function toArray(): array
    {
        return [
            self::keyword() => $this->value,
        ];
    }

    public static function keyword(): string
    {
        return 'const';
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
