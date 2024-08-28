<?php

namespace MohammadAlavi\LaravelOpenApi\Helpers;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use ReflectionType;

class SchemaHelper
{
    public static function guessFromReflectionType(ReflectionType $reflectionType): Schema
    {
        return match ($reflectionType->getName()) {
            'int' => Schema::integer(),
            'bool' => Schema::boolean(),
            default => Schema::string(),
        };
    }
}
