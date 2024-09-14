<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;

class ParameterFactory extends AbstractFactory
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
