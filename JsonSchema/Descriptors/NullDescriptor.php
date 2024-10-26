<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

// TODO: does all need to extend form ExtensibleObject?
// Can't this be done via Composition instead of Inheritance?
// Like the way we are doing it with MetaData.php?
final class NullDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

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
