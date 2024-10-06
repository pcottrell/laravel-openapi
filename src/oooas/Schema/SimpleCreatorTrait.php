<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

trait SimpleCreatorTrait
{
    final public static function create(): static
    {
        return new static();
    }
}
