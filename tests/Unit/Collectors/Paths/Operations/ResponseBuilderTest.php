<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Response as ResponseAttribute;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ResponsesBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use Tests\Doubles\Stubs\Attributes\ResponsesFactory;
use Tests\Doubles\Stubs\Collectors\Paths\Operations\TestReusableResponse;

describe(class_basename(ResponsesBuilder::class), function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInformation::create(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new ResponseAttribute(ResponsesFactory::class),
        ]);
        $builder = new ResponsesBuilder();

        $result = $builder->build($routeInformation->responsesAttributes());

        expect($result)->toHaveCount(1)
            ->and($result[0])->toBeInstanceOf(Response::class);
    });

    it('can handle reusable components', function (): void {
        $routeInformation = RouteInformation::create(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new ResponseAttribute(ResponsesFactory::class),
            new ResponseAttribute(TestReusableResponse::class),
        ]);
        $builder = new ResponsesBuilder();

        $result = $builder->build($routeInformation->responsesAttributes());

        $response = $result[0];
        $reusableResponse = $result[1];
        expect($result)->toHaveCount(2)
            ->and($response)->toBeInstanceOf(Response::class)
            ->and($reusableResponse)->toBeInstanceOf(Reference::class)
            ->and($reusableResponse->statusCode())->toBe(200)
            ->and($reusableResponse->description())->toBe('Reusable Response');
    });
})->covers(ResponsesBuilder::class);
