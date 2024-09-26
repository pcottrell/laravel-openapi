<?php

use Illuminate\Support\Facades\Route;
use Mockery\MockInterface;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use Tests\Doubles\Stubs\Collectors\Components\PathMiddlewareStub;

describe('PathBuilder', function (): void {
    beforeEach(function (): void {
        $this->anotherCustomCollectionViaController = RouteInformation::createFromRoute(
            Route::get('/belongs-to-another-custom-collection-through-controller', static fn () => 'example'),
        );
        $this->anotherCustomCollectionViaController->controllerAttributes = collect([
            new Collection('another-collection'),
        ]);
        $this->anotherCustomCollectionViaControllerAction = RouteInformation::createFromRoute(
            Route::get('/belongs-to-another-custom-collection-through-path-item', static fn () => 'example'),
        );
        $this->anotherCustomCollectionViaControllerAction->actionAttributes = collect([
            new Collection('another-collection'),
        ]);
        $this->routeCollector = Mockery::mock(RouteCollector::class, function (MockInterface $mock) {
            $noCollection = RouteInformation::createFromRoute(
                Route::get('/belongs-to-no-collection', static fn () => 'example'),
            );
            $defaultCollectionViaController = RouteInformation::createFromRoute(
                Route::get('/belongs-to-default-collection-through-controller', static fn () => 'example'),
            );
            $defaultCollectionViaController->controllerAttributes = collect([
                new Collection(Generator::COLLECTION_DEFAULT),
            ]);
            $defaultCollectionViaControllerAction = RouteInformation::createFromRoute(
                Route::get('/belongs-to-default-collection-through-path-item', static fn () => 'example'),
            );
            $defaultCollectionViaControllerAction->actionAttributes = collect([
                new Collection(Generator::COLLECTION_DEFAULT),
            ]);
            $customCollectionViaController = RouteInformation::createFromRoute(
                Route::get('/belongs-to-custom-collection-through-controller', static fn () => 'example'),
            );
            $customCollectionViaController->controllerAttributes = collect([
                new Collection('custom'),
            ]);
            $customCollectionViaControllerAction = RouteInformation::createFromRoute(
                Route::get('/belongs-to-custom-collection-through-path-item', static fn () => 'example'),
            );
            $customCollectionViaControllerAction->actionAttributes = collect([
                new Collection('custom'),
            ]);
            $mock->expects('getRoutes')->andReturn(collect([
                $noCollection,
                $defaultCollectionViaController,
                $defaultCollectionViaControllerAction,
                $customCollectionViaController,
                $customCollectionViaControllerAction,
                $this->anotherCustomCollectionViaController,
                $this->anotherCustomCollectionViaControllerAction,
            ])->shuffle());
        });
    });

    it('can be created with default collection', function (): void {
        $operationBuilder = app(OperationBuilder::class);
        $pathBuilder = new PathBuilder($operationBuilder, $this->routeCollector);

        $result = $pathBuilder->build(Generator::COLLECTION_DEFAULT);

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(3)
            ->and($result)->each(function (Pest\Expectation $pathItem) {
                $pathItem->toBeInstanceOf(PathItem::class);
            });
    });

    it('can be created with custom collection', function (): void {
        $operationBuilder = app(OperationBuilder::class);
        $pathBuilder = new PathBuilder($operationBuilder, $this->routeCollector);

        $result = $pathBuilder->build('custom');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(2)
            ->and($result)->each(function (Pest\Expectation $pathItem) {
                $pathItem->toBeInstanceOf(PathItem::class);
            });
    });

    it('can be created with middleware', function (): void {
        $operationBuilder = app(OperationBuilder::class);
        $pathBuilder = new PathBuilder($operationBuilder, $this->routeCollector);
        $middlewareSpyA = Mockery::spy(PathMiddlewareStub::class);
        $middlewareSpyB = Mockery::spy(PathMiddlewareStub::class);
        $middlewares = [
            $middlewareSpyA,
            $middlewareSpyB,
        ];

        $result = $pathBuilder->build('another-collection', ...$middlewares);

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(2)
            ->and($result)->each(function (Pest\Expectation $pathItem) {
                $pathItem->toBeInstanceOf(PathItem::class);
            });
        $middlewareSpyA->shouldHaveReceived()->before($this->anotherCustomCollectionViaController)->once();
        $middlewareSpyA->shouldHaveReceived()->before($this->anotherCustomCollectionViaControllerAction)->once();
        $middlewareSpyA->shouldHaveReceived()->after(Mockery::type(PathItem::class))->twice();
        $middlewareSpyB->shouldHaveReceived()->before($this->anotherCustomCollectionViaController)->once();
        $middlewareSpyB->shouldHaveReceived()->before($this->anotherCustomCollectionViaControllerAction)->once();
        $middlewareSpyB->shouldHaveReceived()->after(Mockery::type(PathItem::class))->twice();
    });
})->covers(PathBuilder::class);
