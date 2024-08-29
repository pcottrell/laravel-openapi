<?php

namespace Tests\Unit\Attributes\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class ParametersFactoryStub extends ParametersFactory
{
    public function build(): array
    {
        return [];
    }
}