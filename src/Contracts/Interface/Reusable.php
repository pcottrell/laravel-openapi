<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Reference;

interface Reusable extends SimpleCreator
{
    public static function ref(): Reference|string;

    public static function key(): string;
}
