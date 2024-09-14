<?php

namespace Tests\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;

class ParameterFactoryStub extends ParameterFactory
{
    public function build(): array
    {
        return [];
    }
}
