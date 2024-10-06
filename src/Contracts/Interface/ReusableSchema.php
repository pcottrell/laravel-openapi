<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

interface ReusableSchema extends Reusable
{
    public static function ref(): string;
}
