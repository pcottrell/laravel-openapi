<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory as ResponseFactoryContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

class ResponseFactory implements ResponseFactoryContract
{
    public function build(): Response
    {
        return Response::create();
    }
}
