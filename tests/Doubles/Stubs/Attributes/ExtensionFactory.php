<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ExtensionFactory as AbstractFactory;

class ExtensionFactory extends AbstractFactory
{
    public function build(): array
    {
        return [];
    }

    public function key(): string
    {
        return 'x-key';
    }

    public function value(): string
    {
        return 'value';
    }
}
