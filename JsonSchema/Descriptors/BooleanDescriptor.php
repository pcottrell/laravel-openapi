<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class BooleanDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

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
