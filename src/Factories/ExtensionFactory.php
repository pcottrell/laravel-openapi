<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

abstract class ExtensionFactory
{
    abstract public function key(): string;

    abstract public function value(): array|string|Schema|null;
}
