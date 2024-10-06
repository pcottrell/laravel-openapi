<?php

namespace Tests\Doubles\Stubs\Concerns;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;

class NotReusableResponseFactory implements ResponseFactory
{
    public function build(): Response
    {
        return Response::create();
    }
}
