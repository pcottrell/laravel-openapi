<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Response as ResponseAttribute;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use Tests\Doubles\Stubs\Attributes\ResponseFactory;
use Tests\Doubles\Stubs\Collectors\Paths\Operations\TestReusableResponse;

describe('ResponseBuilder', function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInformation::createFromRoute(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new ResponseAttribute(ResponseFactory::class),
        ]);
        $builder = new ResponseBuilder();

        $result = $builder->build(...$routeInformation->responseAttributes());

        expect($result)->toHaveCount(1)
            ->and($result[0])->toBeInstanceOf(Response::class);
    });

    it('can handle reusable components', function (): void {
        $routeInformation = RouteInformation::createFromRoute(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new ResponseAttribute(ResponseFactory::class),
            new ResponseAttribute(TestReusableResponse::class),
        ]);
        $builder = new ResponseBuilder();

        $result = $builder->build(...$routeInformation->responseAttributes());

        $response = $result[0];
        $reusableResponse = $result[1];
        expect($result)->toHaveCount(2)
            ->and($response)->toBeInstanceOf(Response::class)
            ->and($reusableResponse)->toBeInstanceOf(Reference::class)
            ->and($reusableResponse->statusCode)->toBe(200)
            ->and($reusableResponse->description)->toBe('Reusable Response');
    });
})->covers(ResponseBuilder::class);
