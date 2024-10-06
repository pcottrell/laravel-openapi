<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Response;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

class ImplicitCollectionResponse extends ReusableResponseFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}
