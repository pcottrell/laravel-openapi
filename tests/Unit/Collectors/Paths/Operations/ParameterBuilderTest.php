<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters as ParameterAttribute;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ParametersBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInfo;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use Tests\Doubles\Stubs\Attributes\ParameterFactory;
use Tests\Doubles\Stubs\Collectors\Paths\Operations\TestController;

describe('ParameterBuilder', function (): void {
    it('can be created', function (): void {
        $routeInformation = RouteInfo::create(
            Route::get('/example', static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new ParameterAttribute(ParameterFactory::class),
        ]);
        $builder = new ParametersBuilder();

        $result = $builder->build($routeInformation);

        expect($result)->not()->toBeNull()
            ->and($result->all())->toHaveCount(4);
    });

    it('can automatically create parameters from url params', function (array $params, int $count): void {
        $routeInformation = RouteInfo::create(
            Route::get('/example/{id}', [TestController::class, 'actionWithTypeHintedParams']),
        );
        $routeInformation->actionAttributes = collect($params);
        $builder = new ParametersBuilder();

        $result = $builder->build($routeInformation);

        $urlParam = $result->all()[0];
        expect($result->all())->toHaveCount($count)
            ->and($urlParam)->toBeInstanceOf(Parameter::class)
            ->and($urlParam->name)->toBe('id')
            ->and($urlParam->required)->toBeTrue();
    })->with([
        'with action params' => [
            'params' => [new ParameterAttribute(ParameterFactory::class)],
            'count' => 5,
        ],
        'without action params' => [
            'params' => [],
            'count' => 1,
        ],
    ]);

    it('can guess parameter name if it is type hinted in controller method', function (): void {
        $routeInformation = RouteInfo::create(
            Route::get('/example/{id}/{unHinted}/{unknown}', [TestController::class, 'actionWithTypeHintedParams']),
        );
        $builder = new ParametersBuilder();

        $result = $builder->build($routeInformation);

        $typeHintedParam = $result->all()[0];
        expect($result->asArray())->toHaveCount(2)
            ->and($typeHintedParam->name)->toBe('id')
            ->and($typeHintedParam->required)->toBeTrue()
            ->and($typeHintedParam->schema->is(Type::integer()->value()))->toBeTrue();
    });
})->covers(ParametersBuilder::class);
