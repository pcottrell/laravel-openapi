<?php

use Illuminate\Contracts\Foundation\Application;
use MohammadAlavi\LaravelOpenApi\Contracts\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\OpenApiServiceProvider;

describe('OpenApiServiceProvider', function (): void {
    it('correctly registers stuff', function (): void {
        app()->register(OpenApiServiceProvider::class);
        /** @var Application $app */
        $app = app();
        expect($app->get('config')->get('openapi'))->toBe(
            require __DIR__ . '/../../config/openapi.php',
        );

        $expectedBindings = [
            Generator::class,
            RouteCollector::class,
        ];
        foreach ($expectedBindings as $binding) {
            expect($app->bound($binding))->toBeTrue();
        }
    });
})->covers(OpenApiServiceProvider::class);
