<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathItemBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use Pest\Expectation;
use Tests\Doubles\Stubs\CollectibleClass;
use Tests\Doubles\Stubs\Collectors\Components\PathMiddlewareStub;

describe(class_basename(PathsBuilder::class), function (): void {
    it('can be created with middleware', function (): void {
        $routeCollector = Mockery::spy(RouteCollector::class);
        $testCollection = RouteInformation::createFromRoute(Route::get('/test-collection', CollectibleClass::class));
        $routeCollector->allows()->whereInCollection('TestCollection')->andReturn(collect([
            $testCollection,
        ]));
        $pathItemBuilder = app(PathItemBuilder::class);
        $pathBuilder = new PathsBuilder($pathItemBuilder, $routeCollector);
        $pathMiddlewareSpyA = Mockery::spy(PathMiddlewareStub::class);
        $pathMiddlewareSpyB = Mockery::spy(PathMiddlewareStub::class);
        $middlewares = [
            $pathMiddlewareSpyA,
            $pathMiddlewareSpyB,
        ];

        $result = $pathBuilder->build('TestCollection', ...$middlewares);

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(1)
            ->and($result)->each(function (Expectation $expectation): void {
                $expectation->toBeInstanceOf(PathItem::class);
            });
        $pathMiddlewareSpyA->shouldHaveReceived()->before($testCollection)->once();
        $pathMiddlewareSpyB->shouldHaveReceived()->before($testCollection)->once();
        $pathMiddlewareSpyA->shouldHaveReceived()->after(Mockery::type(PathItem::class))->once();
        $pathMiddlewareSpyB->shouldHaveReceived()->after(Mockery::type(PathItem::class))->once();
    });
})->covers(PathsBuilder::class);
