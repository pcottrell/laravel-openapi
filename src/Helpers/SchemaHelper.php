<?php

namespace MohammadAlavi\LaravelOpenApi\Helpers;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use ReflectionType;

class SchemaHelper
{
    public static function guessFromReflectionType(ReflectionType $reflectionType): Schema
    {
        switch ($reflectionType->getName()) {
            case 'int':
                return Schema::integer();
            case 'bool':
                return Schema::boolean();
        }

        return Schema::string();
    }
}
