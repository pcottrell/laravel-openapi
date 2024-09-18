<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Collectors\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use Tests\Doubles\Stubs\Collectors\ControllerWithoutOperationStub;
use Tests\Doubles\Stubs\Collectors\ControllerWithoutPathItemStub;
use Tests\Doubles\Stubs\Collectors\ControllerWithPathItemAndOperationStub;

describe('RouteCollector', function (): void {
    it('can collect routes', function (): void {
        Route::get('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        Route::post('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        Route::get('/has-no-path-item', ControllerWithoutPathItemStub::class);
        Route::put('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        Route::patch('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        Route::get('/has-no-operation', ControllerWithoutOperationStub::class);
        Route::delete('/has-both-pathItem-and-operation', ControllerWithPathItemAndOperationStub::class);
        $collector = app(RouteCollector::class);

        $result = $collector->getRoutes();

        expect($result)->toHaveCount(5)
            and $result->each(fn ($route) => expect($route)->toBeInstanceOf(RouteInformation::class));
    });
})->covers(RouteCollector::class);
