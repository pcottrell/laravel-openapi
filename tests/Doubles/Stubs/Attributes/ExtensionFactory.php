<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ExtensionFactory extends AbstractFactory
{
    public function build(): array
    {
        return [];
    }

    public function key(): string
    {
        return 'key';
    }

    public function value(): array|string|Schema|null
    {
        return 'value';
    }
}
