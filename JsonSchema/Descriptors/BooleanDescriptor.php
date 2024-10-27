<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\Applicator;
use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\HasApplicatorTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData\HasMetaDataTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class BooleanDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;
    use HasMetaDataTrait;
    use HasApplicatorTrait;

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::boolean();
        $instance->metaData = MetaData::create();
        $instance->applicator = Applicator::create();

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$this->metaData->jsonSerialize(),
            ...$this->applicator->jsonSerialize(),
        ]);
    }
}
