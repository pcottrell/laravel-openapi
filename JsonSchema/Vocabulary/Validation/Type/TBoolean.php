<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\JsonSchema;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class TBoolean extends ExtensibleObject implements JsonSchema
{
    private Type $type;

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::boolean();

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
        ]);
    }
}
