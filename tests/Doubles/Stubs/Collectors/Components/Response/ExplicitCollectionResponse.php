<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Response;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

#[Collection('test')]
class ExplicitCollectionResponse extends ReusableResponseFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}
