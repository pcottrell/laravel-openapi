<?php

namespace Tests\Doubles\Stubs\Concerns;

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;

class NotReusableResponseFactory extends ResponseFactory
{
    use Referencable;

    public function build(): Response
    {
        return Response::create();
    }
}