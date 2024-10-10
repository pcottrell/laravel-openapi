<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema;

trait SimpleCreatorTrait
{
    final public static function create(): static
    {
        return new static();
    }
}
