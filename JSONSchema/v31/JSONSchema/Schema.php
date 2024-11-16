<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ArrayBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\BooleanBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ConstantBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\EnumBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NullBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NumberBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ObjectBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\IntegerBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\StringBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\SchemaBuilder;

final readonly class Schema
{
    public static function null(): NullBuilder
    {
        return SchemaBuilder::create()->null();
    }

    public static function boolean(): BooleanBuilder
    {
        return SchemaBuilder::create()->boolean();
    }

    public static function string(): StringBuilder
    {
        return SchemaBuilder::create()->string();
    }

    public static function integer(): IntegerBuilder
    {
        return SchemaBuilder::create()->integer();
    }

    public static function number(): NumberBuilder
    {
        return SchemaBuilder::create()->number();
    }

    public static function object(): ObjectBuilder
    {
        return SchemaBuilder::create()->object();
    }

    public static function array(): ArrayBuilder
    {
        return SchemaBuilder::create()->array();
    }

    public static function const(mixed $value): ConstantBuilder
    {
        return SchemaBuilder::create()->constant($value);
    }

    public static function enum(mixed ...$value): EnumBuilder
    {
        return SchemaBuilder::create()->enumerator(...$value);
    }
}
