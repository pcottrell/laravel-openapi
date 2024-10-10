<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableSchema as ReusableSchemaContract;

abstract class ReusableSchema extends Reusable implements ReusableSchemaContract
{
    final public static function ref(): string
    {
        return self::path();
    }
}
