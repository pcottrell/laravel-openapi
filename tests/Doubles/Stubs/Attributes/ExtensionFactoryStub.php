<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ExtensionFactoryStub extends ExtensionFactory
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
