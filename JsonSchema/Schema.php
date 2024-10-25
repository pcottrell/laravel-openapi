<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

// TODO: for schema the $key is required I think. It should bre required when creating it via ny construction method

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\ArrayDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\BooleanDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\NullDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\IntegerDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\NumberDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\ObjectDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\StringDescriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Constant;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Enum;

abstract class Schema
{
    // TODO: Implement $id from JSON SCHEMA.
    // https://www.learnjsonschema.com/2020-12/core/id/#
    // Also look at OAS spec 3.1
    // public string|null $id = null;

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

    public static function array(): ObjectDescriptor
    {
        return ArrayDescriptor::create();
    }

    public static function enum(...$values): Enum
    {
        return Enum::create(...$values);
    }

    public static function const(mixed $value): Constant
    {
        return Constant::create($value);
    }
}
