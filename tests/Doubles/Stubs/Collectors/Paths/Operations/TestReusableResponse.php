<?php

namespace Tests\Doubles\Stubs\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;

class TestReusableResponse extends ReusableResponseFactory
{
    public function build(): Response
    {
        return Response::create(200, 'Reusable Response');
    }
}
