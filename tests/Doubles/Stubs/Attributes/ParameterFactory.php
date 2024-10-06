<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ParameterFactory as ParameterFactoryContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;

class ParameterFactory implements ParameterFactoryContract
{
    public function build(): array
    {
        return [
            Parameter::create(),
            Parameter::create(),
            Parameter::create(),
        ];
    }
}
