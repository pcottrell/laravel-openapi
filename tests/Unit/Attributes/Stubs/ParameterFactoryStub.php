<?php

namespace Tests\Unit\Attributes\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;

class ParameterFactoryStub extends ParameterFactory
{
    public function build(): array
    {
        return [];
    }
}