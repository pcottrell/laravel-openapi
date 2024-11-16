<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ArrayBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\BooleanBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ConstantBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\EnumBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\IntegerBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NumberBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ObjectBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\ExtendedBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NullBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\StringBuilder;

class SchemaBuilder extends ExtendedBuilder implements Builder
{
    public static function create(): Builder
    {
        return (new static())->schema('https://spec.openapis.org/oas/3.1/dialect/base');
    }

    public function null(): NullBuilder
    {
        return $this->type(Type::null());
    }

    public function boolean(): BooleanBuilder
    {
        return $this->type(Type::boolean());
    }

    public function string(): StringBuilder
    {
        return $this->type(Type::string());
    }

    public function integer(): IntegerBuilder
    {
        return $this->type(Type::integer());
    }

    public function number(): NumberBuilder
    {
        return $this->type(Type::number());
    }

    public function object(): ObjectBuilder
    {
        return $this->type(Type::object());
    }

    public function array(): ArrayBuilder
    {
        return $this->type(Type::array());
    }

    public function constant(mixed $value): ConstantBuilder
    {
        return $this->const($value);
    }

    public function enumerator(mixed ...$value): EnumBuilder
    {
        return $this->enum(...$value);
    }

    public function jsonSerialize(): array
    {
        return [
            ...parent::jsonSerialize(),
        ];
    }
}
