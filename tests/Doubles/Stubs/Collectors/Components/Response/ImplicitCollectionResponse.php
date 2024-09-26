<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Response;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

class ImplicitCollectionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::create('default collection Response');
    }
}
