<?php

namespace MohammadAlavi\LaravelOpenApi\Helpers;

class BuilderHelper
{
    public static function hasInvalidField(array $array, string $name): bool
    {
        return !array_key_exists($name, $array) || empty($array[$name]);
    }
}
