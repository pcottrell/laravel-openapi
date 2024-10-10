<?php

namespace Tests\Doubles\Stubs\Collectors\Components\RequestBody;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;

class ImplicitCollectionRequestBody extends ReusableRequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
