<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Reference;

interface Reusable
{
    public static function ref(): Reference|string;
}
