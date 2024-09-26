<?php

namespace Tests\Doubles\Stubs\Collectors\Components\RequestBody;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

#[Collection('test')]
class ExplicitCollectionRequestBody extends RequestBodyFactory implements Reusable
{
    public function build(): RequestBody
    {
        return RequestBody::create('test collection RequestBody');
    }
}
