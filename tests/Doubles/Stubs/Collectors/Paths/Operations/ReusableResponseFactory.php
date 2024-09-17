<?php

namespace Tests\Doubles\Stubs\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;

class ReusableResponseFactory extends AbstractFactory implements Reusable
{
    public function build(): Response
    {
        return Response::create('test')->statusCode(200)->description('Reusable Response');
    }
}
