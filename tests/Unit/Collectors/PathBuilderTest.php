<?php

use Illuminate\Support\Facades\Route;
use Mockery\MockInterface;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use Pest\Expectation;
use Tests\Doubles\Stubs\Collectors\Components\PathMiddlewareStub;

describe('PathBuilder', function (): void {
    beforeEach(function (): void {
        $this->anotherCustomCollectionViaController = RouteInformation::createFromRoute(
            Route::get('/belongs-to-another-custom-collection-through-controller', static fn (): string => 'example'),
        );
        $this->anotherCustomCollectionViaController->controllerAttributes = collect([
            new Collection('another-collection'),
        ]);
        $this->anotherCustomCollectionViaControllerAction = RouteInformation::createFromRoute(
            Route::get('/belongs-to-another-custom-collection-through-path-item', static fn (): string => 'example'),
        );
        $this->anotherCustomCollectionViaControllerAction->actionAttributes = collect([
            new Collection('another-collection'),
        ]);
        $this->routeCollector = Mockery::mock(RouteCollector::class, function (MockInterface $mock): void {
            $routeInformation = RouteInformation::createFromRoute(
                Route::get('/belongs-to-no-collection', static fn (): string => 'example'),
            );
            $defaultCollectionViaController = RouteInformation::createFromRoute(
                Route::get('/belongs-to-default-collection-through-controller', static fn (): string => 'example'),
            );
            $defaultCollectionViaController->controllerAttributes = collect([
                new Collection(Generator::COLLECTION_DEFAULT),
            ]);
            $defaultCollectionViaControllerAction = RouteInformation::createFromRoute(
                Route::get('/belongs-to-default-collection-through-path-item', static fn (): string => 'example'),
            );
            $defaultCollectionViaControllerAction->actionAttributes = collect([
                new Collection(Generator::COLLECTION_DEFAULT),
            ]);
            $customCollectionViaController = RouteInformation::createFromRoute(
                Route::get('/belongs-to-custom-collection-through-controller', static fn (): string => 'example'),
            );
            $customCollectionViaController->controllerAttributes = collect([
                new Collection('custom'),
            ]);
            $customCollectionViaControllerAction = RouteInformation::createFromRoute(
                Route::get('/belongs-to-custom-collection-through-path-item', static fn (): string => 'example'),
            );
            $customCollectionViaControllerAction->actionAttributes = collect([
                new Collection('custom'),
            ]);
            $mock->expects('getRoutes')->andReturn(collect([
                $routeInformation,
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
        $pathBuilder = new PathsBuilder($operationBuilder, $this->routeCollector);

        $result = $pathBuilder->build(Generator::COLLECTION_DEFAULT);

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(3)
            ->and($result)->each(function (Expectation $expectation): void {
                $expectation->toBeInstanceOf(PathItem::class);
            });
    });

    it('can be created with custom collection', function (): void {
        $operationBuilder = app(OperationBuilder::class);
        $pathBuilder = new PathsBuilder($operationBuilder, $this->routeCollector);

        $result = $pathBuilder->build('custom');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(2)
            ->and($result)->each(function (Expectation $expectation): void {
                $expectation->toBeInstanceOf(PathItem::class);
            });
    });

    it('can be created with middleware', function (): void {
        $operationBuilder = app(OperationBuilder::class);
        $pathBuilder = new PathsBuilder($operationBuilder, $this->routeCollector);
        $mock = Mockery::spy(PathMiddlewareStub::class);
        $middlewareSpyB = Mockery::spy(PathMiddlewareStub::class);
        $middlewares = [
            $mock,
            $middlewareSpyB,
        ];

        $result = $pathBuilder->build('another-collection', ...$middlewares);

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(2)
            ->and($result)->each(function (Expectation $expectation): void {
                $expectation->toBeInstanceOf(PathItem::class);
            });
        $mock->shouldHaveReceived()->before($this->anotherCustomCollectionViaController)->once();
        $mock->shouldHaveReceived()->before($this->anotherCustomCollectionViaControllerAction)->once();
        $mock->shouldHaveReceived()->after(Mockery::type(PathItem::class))->twice();
        $middlewareSpyB->shouldHaveReceived()->before($this->anotherCustomCollectionViaController)->once();
        $middlewareSpyB->shouldHaveReceived()->before($this->anotherCustomCollectionViaControllerAction)->once();
        $middlewareSpyB->shouldHaveReceived()->after(Mockery::type(PathItem::class))->twice();
    });
})->covers(PathsBuilder::class);
