<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface;

interface SimpleKeyCreator extends HasKey
{
    public static function create(string $key): static;
}
