<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use Tests\Doubles\Stubs\Attributes\CallbackFactory;
use Tests\Doubles\Stubs\Paths\Operations\ReusableCallbackFactory;

describe('CallbackBuilder', function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInformation::createFromRoute(Route::get('/example', static fn () => 'example'));
        $routeInformation->actionAttributes = collect([
            new Callback(CallbackFactory::class),
        ]);
        $builder = new CallbackBuilder();

        $result = $builder->build($routeInformation);

        expect($result)->toHaveCount(1)
            ->and($result[0])->toBeInstanceOf(PathItem::class);
    });

    it('can handle reusable components', function (): void {
        $routeInformation = RouteInformation::createFromRoute(Route::get('/example', static fn () => 'example'));
        $routeInformation->actionAttributes = collect([
            new Callback(CallbackFactory::class),
            new Callback(ReusableCallbackFactory::class),
        ]);
        $builder = new CallbackBuilder();

        $result = $builder->build($routeInformation);

        $pathItem = $result[0];
        $reusablePathItem = $result[1];
        expect($result)->toHaveCount(2)
            ->and($pathItem)->toBeInstanceOf(PathItem::class)
            ->and($pathItem->ref)->toBeNull()
            ->and($reusablePathItem)->toBeInstanceOf(PathItem::class)
            ->and($reusablePathItem->ref)->toBe('#/components/callbacks/test');
    });
})->covers(CallbackBuilder::class);
