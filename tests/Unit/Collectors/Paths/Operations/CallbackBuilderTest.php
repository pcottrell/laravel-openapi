<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;
use Tests\Doubles\Stubs\Attributes\CallbackFactory;
use Tests\Doubles\Stubs\Collectors\Paths\Operations\ReusableComponentCallbackFactory;

describe('CallbackBuilder', function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInformation::createFromRoute(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new Callback(CallbackFactory::class),
        ]);
        $builder = new CallbackBuilder();

        $result = $builder->build($routeInformation);

        expect($result)->toHaveCount(1)
            ->and($result[0])->toBeInstanceOf(PathItem::class);
    });

    it('can handle reusable components', function (): void {
        $routeInformation = RouteInformation::createFromRoute(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new Callback(CallbackFactory::class),
            new Callback(ReusableComponentCallbackFactory::class),
        ]);
        $builder = new CallbackBuilder();

        $result = $builder->build($routeInformation);

        $pathItem = $result[0];
        /** @var Reference $reusablePathItem */
        $reusablePathItem = $result[1];
        expect($result)->toHaveCount(2)
            ->and($pathItem)->toBeInstanceOf(PathItem::class)
            ->and($reusablePathItem)->toBeInstanceOf(Reference::class)
            ->and($reusablePathItem->ref)
            ->toBe(
                '#/components/callbacks/ReusableComponentCallbackFactory',
            );
    });
})->covers(CallbackBuilder::class);
