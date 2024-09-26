<?php

namespace Tests\Doubles\Stubs\Collectors\Components\RequestBody;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

class ImplicitCollectionRequestBody extends RequestBodyFactory implements Reusable
{
    public function build(): RequestBody
    {
        return RequestBody::create('default collection RequestBody');
    }
}
