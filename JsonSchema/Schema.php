<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

// TODO: for schema the $key is required I think. It should bre required when creating it via ny construction method

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\ArrayDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\BooleanDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\ConstantDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\EnumDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\NullDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\IntegerDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\NumberDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\ObjectDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\StringDescriptor;

abstract class Schema
{
    // TODO: Implement $id from JSON SCHEMA.
    // https://www.learnjsonschema.com/2020-12/core/id/#
    // Also look at OAS spec 3.1
    // public string|null $id = null;

    // TODO: Creating an schema that have multiple types is valid in JSON SCHEMA. Implement it.
    // How does the non-overlapping type specific validation work?
    // For example, if the type is integer and string, how does the minLength validation work?

    public static function null(): NullDescriptor
    {
        return NullDescriptor::create();
    }

    public static function boolean(): BooleanDescriptor
    {
        return BooleanDescriptor::create();
    }

    public static function string(): StringDescriptor
    {
        return StringDescriptor::create();
    }

    public static function integer(): IntegerDescriptor
    {
        return IntegerDescriptor::create();
    }

    public static function number(): NumberDescriptor
    {
        return NumberDescriptor::create();
    }

    public static function object(): ObjectDescriptor
    {
        return ObjectDescriptor::create();
    }

    public static function array(): ArrayDescriptor
    {
        return ArrayDescriptor::create();
    }

    public static function enum(...$values): EnumDescriptor
    {
        return EnumDescriptor::create(...$values);
    }

    public static function const(mixed $value): ConstantDescriptor
    {
        return ConstantDescriptor::create($value);
    }
}
