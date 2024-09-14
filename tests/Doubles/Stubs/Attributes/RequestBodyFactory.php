<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;

class RequestBodyFactory extends AbstractFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
