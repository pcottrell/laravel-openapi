<?php

namespace Tests\Unit\Attributes\Stubs;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class ResponseFactoryStub extends ResponseFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}