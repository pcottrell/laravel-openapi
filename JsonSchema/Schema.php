<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

// TODO: for schema the $key is required I think. It should bre required when creating it via ny construction method

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Constant;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Enum;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TArray;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TBoolean;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TInteger;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TNull;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TNumber;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TObject;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TString;

abstract class Schema
{
    // TODO: Implement $id from JSON SCHEMA.
    // https://www.learnjsonschema.com/2020-12/core/id/#
    // Also look at OAS spec 3.1
    // public string|null $id = null;

    public static function null(): TNull
    {
        return TNull::create();
    }

    public static function boolean(): TBoolean
    {
        return TBoolean::create();
    }

    public static function string(): TString
    {
        return TString::create();
    }

    public static function integer(): TInteger
    {
        return TInteger::create();
    }

    public static function number(): TNumber
    {
        return TNumber::create();
    }

    public static function object(): TObject
    {
        return TObject::create();
    }

    public static function array(): TObject
    {
        return TArray::create();
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
