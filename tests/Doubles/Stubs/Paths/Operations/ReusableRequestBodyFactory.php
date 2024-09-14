<?php

namespace Tests\Doubles\Stubs\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;

class ReusableRequestBodyFactory extends AbstractFactory implements Reusable
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
