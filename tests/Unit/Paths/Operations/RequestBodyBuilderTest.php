<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;
use Tests\Doubles\Stubs\Attributes\RequestBodyFactory;
use Tests\Doubles\Stubs\Paths\Operations\ReusableRequestBodyFactory;

describe('RequestBodyBuilder', function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInformation::createFromRoute(Route::get('/example', static fn () => 'example'));
        $routeInformation->actionAttributes = collect([
            new RequestBodyAttribute(RequestBodyFactory::class),
        ]);
        $builder = new RequestBodyBuilder();

        $result = $builder->build($routeInformation);

        expect($result)->toBeInstanceOf(RequestBody::class);
    });

    it('can handle reusable components', function (): void {
        $routeInformation = RouteInformation::createFromRoute(Route::get('/example', static fn () => 'example'));
        $routeInformation->actionAttributes = collect([
            new RequestBodyAttribute(ReusableRequestBodyFactory::class),
        ]);
        $builder = new RequestBodyBuilder();

        $result = $builder->build($routeInformation);

        expect($result)->toBeInstanceOf(RequestBody::class)
            ->and($result->ref)->toBe('#/components/requestBodies/' . $result->objectId);
    });
})->covers(RequestBodyBuilder::class);
