<?php

namespace Tests\Doubles\Fakes\Collectable\Components\Response;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;

class ImplicitCollectionResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::create();
    }
}
