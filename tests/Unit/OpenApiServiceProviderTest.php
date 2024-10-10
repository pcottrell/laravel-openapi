<?php

use Illuminate\Contracts\Foundation\Application;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Providers\OpenApiServiceProvider;

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
        foreach ($expectedBindings as $expectedBinding) {
            expect($app->bound($expectedBinding))->toBeTrue();
        }
    });
})->covers(OpenApiServiceProvider::class);
