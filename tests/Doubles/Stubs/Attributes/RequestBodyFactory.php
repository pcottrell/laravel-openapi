<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\RequestBodyFactory as RequestBodyFactoryContract;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;

class RequestBodyFactory implements RequestBodyFactoryContract
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
