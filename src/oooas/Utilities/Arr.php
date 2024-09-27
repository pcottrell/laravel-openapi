<?php

namespace MohammadAlavi\ObjectOrientedOAS\Utilities;

use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extension;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;

/** @internal */
class Arr
{
    public static function filter(array $array): array
    {
        foreach ($array as $index => &$value) {
            // If the value is an object, then parse to array.
            if ($value instanceof ExtensibleObject) {
                $value = $value->jsonSerialize();
            }

            // If the value is a filled array, then recursively filter it.
            if (is_array($value)) {
                $value = static::filter($value);
                continue;
            }

            // If the value is a specification extension, then skip the null
            // check below.
            if (is_string($index) && Extension::isExtension($index)) {
                continue;
            }

            // If the value is null, then remove it.
            if (is_null($value)) {
                unset($array[$index]);
            }
        }

        return $array;
    }
}
