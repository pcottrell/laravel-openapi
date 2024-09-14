<?php

namespace Tests\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;

class ResponseFactoryStub extends ResponseFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}
