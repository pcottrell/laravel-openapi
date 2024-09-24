<?php

namespace Tests;

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;

abstract class IntegrationTestCase extends TestCase
{
    public function generate(): OpenApi
    {
        return $this->app->make(Generator::class)->generate();
    }
}
