<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Collections\Parameters;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ParametersFactory as ParametersFactoryInterface;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use Tests\Doubles\Stubs\Concerns\TestReusableParameter;

class ParameterFactory implements ParametersFactoryInterface
{
    public function build(): Parameters
    {
        return Parameters::create(
            Parameter::create(),
            Parameter::create(),
            TestReusableParameter::create(),
            Parameter::create(),
        );
    }
}
