<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory as AbstractFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

class ResponseFactory extends AbstractFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}
