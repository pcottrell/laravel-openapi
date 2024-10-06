<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Reference;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

class RequestBodyBuilder
{
    public function build(RequestBodyAttribute $attribute): RequestBody|Reference
    {
        if (is_a($attribute->factory, ReusableRequestBodyFactory::class, true)) {
            return $attribute->factory::ref();
        }

        /** @var RequestBodyFactory $factory */
        $factory = app($attribute->factory);

        return $factory->build();
    }
}
