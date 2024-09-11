<?php

namespace Tests\Unit\Attributes\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;

class RequestBodyFactoryStub extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
