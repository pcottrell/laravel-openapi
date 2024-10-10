<?php

namespace MohammadAlavi\LaravelOpenApi\Http;

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;

class OpenApiController
{
    public function show(Generator $generator): OpenApi
    {
        return $generator->generate();
    }
}
