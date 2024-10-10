<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;

class ParameterBuilder
{
    public function build(RequestBodyAttribute $attribute): Parameter|Reference
    {
        if (is_a($attribute->factory, ReusableParameterFactory::class, true)) {
            return $attribute->factory::ref();
        }

        /** @var ParameterFactory $factory */
        $factory = app($attribute->factory);

        return $factory->build();
    }
}
