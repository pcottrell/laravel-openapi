<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Reference;

interface ReusableRefObj extends Reusable
{
    public static function ref(): Reference;
}
