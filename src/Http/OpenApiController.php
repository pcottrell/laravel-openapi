<?php

namespace MohammadAlavi\LaravelOpenApi\Http;

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;

class OpenApiController
{
    public function show(Generator $generator): OpenApi
    {
        return $generator->generate();
    }
}
