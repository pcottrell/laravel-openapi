<?php

namespace Tests;

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\OpenApiServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            OpenApiServiceProvider::class,
        ];
    }

    protected function generate(): OpenApi
    {
        return $this->app[Generator::class]->generate();
    }
}
