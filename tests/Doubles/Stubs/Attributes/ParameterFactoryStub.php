<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;

class ParameterFactoryStub extends ParameterFactory
{
    public function build(): array
    {
        return [
            Parameter::create('A'),
            Parameter::create('B'),
            Parameter::create('C'),
        ];
    }
}
