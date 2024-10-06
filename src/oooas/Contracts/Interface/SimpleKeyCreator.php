<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface;

interface SimpleKeyCreator extends HasKey
{
    public static function create(string $key): static;
}
