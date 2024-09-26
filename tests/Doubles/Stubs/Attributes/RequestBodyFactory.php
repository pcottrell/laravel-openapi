<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory as AbstractFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

class RequestBodyFactory extends AbstractFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
