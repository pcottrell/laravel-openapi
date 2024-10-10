<?php

namespace Tests\Doubles\Stubs\Concerns;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory as AbstractReusableParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;

class TestReusableParameter extends AbstractReusableParameterFactory
{
    public function build(): Parameter
    {
        return Parameter::query()
            ->name('TestReusableParameter')
            ->description('ReusableParameterStub description')
            ->required();
    }
}
