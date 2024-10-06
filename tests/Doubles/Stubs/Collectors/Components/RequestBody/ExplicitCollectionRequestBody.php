<?php

namespace Tests\Doubles\Stubs\Collectors\Components\RequestBody;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

#[Collection('test')]
class ExplicitCollectionRequestBody extends ReusableRequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
