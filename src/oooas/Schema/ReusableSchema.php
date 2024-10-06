<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableSchema as ReusableSchemaContract;
use Webmozart\Assert\Assert;

abstract class ReusableSchema extends Reusable implements ReusableSchemaContract
{
    final public static function ref(): string
    {
        return self::path();
    }
}
