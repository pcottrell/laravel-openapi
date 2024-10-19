<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Services\RouteCollector;
use Tests\Doubles\Stubs\Collectors\ControllerWithPathItemAndOperationStub;

describe(class_basename(PathsBuilder::class), function (): void {
    it('can be created', function (): void {
        Route::get('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        $routeCollector = app(RouteCollector::class);
        $routeInfo = $routeCollector->all();
        $builder = app(PathsBuilder::class);

        $result = $builder->build($routeInfo);

        expect($result->asArray())->toHaveCount(1)
            ->and($result->asArray())->toBe([
                '/has-both-pathItem-and-operation' => [
                    'get' => [
                        'responses' => [
                            'default' => [
                                'description' => 'Default Response',
                            ],
                        ],
                    ],
                ],
            ]);
    });
})->covers(PathsBuilder::class);
