<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\ParameterCollectionFactory as ParametersFactoryInterface;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use Tests\Doubles\Stubs\Concerns\TestReusableParameter;

class ParameterFactory implements ParametersFactoryInterface
{
    public function build(): ParameterCollection
    {
        return ParameterCollection::create(
            Parameter::create(),
            Parameter::create(),
            TestReusableParameter::create(),
            Parameter::create(),
        );
    }
}
