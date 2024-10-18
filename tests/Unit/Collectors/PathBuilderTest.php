<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use Tests\Doubles\Stubs\CollectibleClass;
use Tests\Doubles\Stubs\Collectors\Components\PathMiddlewareStub;

describe(class_basename(PathsBuilder::class), function (): void {
    it('can be created with middleware', function (): void {
        $routeInformation = RouteInformation::create(
            Route::get('/test-collection', CollectibleClass::class),
        );
        $pathMiddlewareSpyA = Mockery::mock(PathMiddlewareStub::class);
        $pathMiddlewareSpyA->expects()->before()->withAnyArgs()->andReturn($routeInformation);
        $pathMiddlewareSpyA->expects()->after()->withAnyArgs()->andReturn(
            Path::create('/test-collection', PathItem::create()),
        );
        $pathMiddlewareSpyB = Mockery::mock(PathMiddlewareStub::class);
        $pathMiddlewareSpyB->expects()->before()->withAnyArgs()->andReturn($routeInformation);
        $pathMiddlewareSpyB->expects()->after()->withAnyArgs()->andReturn(
            Path::create('/test-collection', PathItem::create()),
        );
        $middlewares = [
            $pathMiddlewareSpyA,
            $pathMiddlewareSpyB,
        ];
        $pathBuilder = app(PathsBuilder::class);

        $result = $pathBuilder->build('TestCollection', ...$middlewares);

        expect($result)->toBeInstanceOf(Paths::class);
    });
})->covers(PathsBuilder::class);
