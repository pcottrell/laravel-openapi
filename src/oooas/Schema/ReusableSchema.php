<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableSchema as ReusableSchemaContract;
use Webmozart\Assert\Assert;

abstract class ReusableSchema implements ReusableSchemaContract
{
    final public static function ref(): string
    {
        return static::basePath() .
            static::componentPath() . '/' .
            static::validate(static::key());
    }

    private static function basePath(): string
    {
        return '#/components';
    }

    abstract protected static function componentPath(): string;

    private static function validate(string $name): string
    {
        Assert::regex($name, '/^[a-zA-Z0-9\.\-_]+$/');

        return $name;
    }

//    public static function key(): string
//    {
//        return class_basename(static::class);
//    }
}
