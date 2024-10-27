<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData\HasMetaDataTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

// TODO: Where should we put Enum and Constant?
// They can both be equally categorized as Validation and Descriptor
final class EnumDescriptor extends Generatable implements SchemaProperty, Validation, Descriptor, TypeAware
{
    use HasMetaDataTrait;

    private array $values;

    // TODO: It would be cool if enums could accept Constant or/and Schema types
    public static function create(...$value): self
    {
        $instance = new self();
        $instance->values = $value;
        $instance->metaData = MetaData::create();

        return $instance;
    }

    public function value(): array
    {
        return $this->values;
    }

    public function is(string $type): bool
    {
        return $type === self::keyword();
    }

    public static function keyword(): string
    {
        return 'enum';
    }

    protected function toArray(): array
    {
        return [
            self::keyword() => $this->values,
            ...$this->metaData->jsonSerialize(),
        ];
    }
}
