<?php

namespace MohammadAlavi\LaravelOpenApi\Tests;

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\OpenApiServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
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
