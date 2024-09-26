<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

abstract class ExtensionFactory
{
    abstract public function key(): string;

    abstract public function value(): mixed;
}
