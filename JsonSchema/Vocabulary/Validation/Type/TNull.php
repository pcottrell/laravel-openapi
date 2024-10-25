<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class TNull extends ExtensibleObject
{
    private Type $type;

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::null();

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
        ]);
    }
}
