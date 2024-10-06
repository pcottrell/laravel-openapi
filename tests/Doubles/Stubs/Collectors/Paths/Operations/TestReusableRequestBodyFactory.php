<?php

namespace Tests\Doubles\Stubs\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

class TestReusableRequestBodyFactory extends ReusableRequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
