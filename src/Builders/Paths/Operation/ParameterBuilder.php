<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;

class ParameterBuilder
{
    public function build(Parameter|ReusableParameterFactory $parameter): Parameter|Reference
    {
        if ($parameter instanceof ReusableParameterFactory) {
            return $parameter::ref();
        }

        return $parameter;
    }
}
