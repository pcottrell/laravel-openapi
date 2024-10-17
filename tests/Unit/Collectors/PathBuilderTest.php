<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathItemBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use Tests\Doubles\Stubs\CollectibleClass;
use Tests\Doubles\Stubs\Collectors\Components\PathMiddlewareStub;

describe(class_basename(PathsBuilder::class), function (): void {
    it('can be created with middleware', function (): void {
        $testCollection = RouteInformation::create(Route::get('/test-collection', CollectibleClass::class));
        $routeCollector = Mockery::mock(RouteCollector::class);
        $routeCollector->allows()
            ->whereInCollection('TestCollection')
            ->andReturn(collect([$testCollection]));

        $pathItemBuilder = app(PathItemBuilder::class);
        $pathBuilder = new PathsBuilder($pathItemBuilder, $routeCollector);
        $pathMiddlewareSpyA = Mockery::spy(PathMiddlewareStub::class);
        $pathMiddlewareSpyB = Mockery::spy(PathMiddlewareStub::class);
        $middlewares = [
            $pathMiddlewareSpyA,
            $pathMiddlewareSpyB,
        ];

        $result = $pathBuilder->build('TestCollection', ...$middlewares);

        expect($result)->toBeInstanceOf(Paths::class);
        $pathMiddlewareSpyA->shouldHaveReceived()->before($testCollection)->once();
        $pathMiddlewareSpyB->shouldHaveReceived()->before($testCollection)->once();
        $pathMiddlewareSpyA->shouldHaveReceived()->after(Mockery::type(Paths::class))->once();
        $pathMiddlewareSpyB->shouldHaveReceived()->after(Mockery::type(Paths::class))->once();
    });
})->covers(PathsBuilder::class);
