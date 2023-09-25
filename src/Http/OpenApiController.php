<?php

namespace Vyuldashev\LaravelOpenApi\Http;

use Vyuldashev\LaravelOpenApi\Generator;
use Vyuldashev\LaravelOpenApi\Objects\OpenApi;

class OpenApiController
{
    public function show(Generator $generator): OpenApi
    {
        return $generator->generate();
    }
}
