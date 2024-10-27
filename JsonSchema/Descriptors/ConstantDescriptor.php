<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData\HasMetaDataTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class ConstantDescriptor extends Generatable implements SchemaProperty, Validation, Descriptor, TypeAware
{
    use HasMetaDataTrait;

    private mixed $value;

    // TODO: It would be cool if constants could accept Schema types
    public static function create($value): self
    {
        $instance = new self();
        $instance->value = $value;
        $instance->metaData = MetaData::create();

        return $instance;
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
            ...$this->metaData->jsonSerialize(),
        ];
    }
}
