<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class Enum extends Generatable implements SchemaProperty, Validation
{
    private array $values;

    // TODO: It would be cool if enums could accept Constant or/and Schema types
    public static function create(...$value): self
    {
        $clone = new self();

        $clone->values = $value;

        return $clone;
    }

    protected function toArray(): array
    {
        return [
            self::keyword() => $this->values,
        ];
    }

    public static function keyword(): string
    {
        return 'enum';
    }

    public function value(): array
    {
        return $this->values;
    }
}
