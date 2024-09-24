<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameter;
use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use MohammadAlavi\LaravelOpenApi\Attributes\Response;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\Objects\SecurityRequirement;
use Tests\Doubles\Stubs\Attributes\CallbackFactory;
use Tests\Doubles\Stubs\Attributes\ExtensionFactory;
use Tests\Doubles\Stubs\Attributes\ParameterFactory;
use Tests\Doubles\Stubs\Attributes\RequestBodyFactory;
use Tests\Doubles\Stubs\Attributes\ResponseFactory;
use Tests\Doubles\Stubs\Attributes\SecuritySchemeFactory;
use Tests\Doubles\Stubs\Servers\ServerWithMultipleVariableFormatting;
use Tests\Doubles\Stubs\Tags\TagWithExternalObjectDoc;

describe('OperationBuilder', function (): void {
    it('can be created in many combinations', function (array $routes, array $expected): void {
        $operation = app(OperationBuilder::class);

        $result = $operation->build($routes);

        /** @var Operation $operationA */
        $operationA = $result[0];
        expect($result)->toBeArray()
            ->and($result)->toHaveCount(1)
            ->and($operationA->ref)->toBe($expected[0]['ref'])
            ->and($operationA->objectId)->toBe($expected[0]['objectId'])
            ->and($operationA->action)->toBe($expected[0]['action'])
            ->and($operationA->tags)->toBe($expected[0]['tags'])
            ->and($operationA->summary)->toBe($expected[0]['summary'])
            ->and($operationA->description)->toBe($expected[0]['description'])
            ->and($operationA->externalDocs)->toBe($expected[0]['externalDocs'])
            ->and($operationA->operationId)->toBe($expected[0]['operationId'])
            ->and($operationA->parameters)->toEqual($expected[0]['parameters'])
            ->and($operationA->requestBody)->toEqual($expected[0]['requestBody'])
            ->and($operationA->responses)->toEqual($expected[0]['responses'])
            ->and($operationA->deprecated)->toBe($expected[0]['deprecated'])
            ->and($operationA->security)->toEqual($expected[0]['security'])
            ->and($operationA->servers)->toEqual($expected[0]['servers'])
            ->and($operationA->callbacks)->toEqual($expected[0]['callbacks']);
    })->with(
        [
            function () {
                $route = RouteInformation::createFromRoute(Route::get('test', static fn () => 'test'));
                $route->actionAttributes = collect([
                    new OperationAttribute(
                        id: 'test',
                        tags: [],
                        security: [],
                        method: 'get',
                        servers: [],
                        summary: '',
                        description: '',
                        deprecated: false,
                    ),
                ]);

                return [
                    'routes' => [$route],
                    'expected' => [
                        [
                            'ref' => null,
                            'summary' => '',
                            'description' => '',
                            'operationId' => 'test',
                            'deprecated' => false,
                            'security' => [],
                            'action' => 'get',
                            'servers' => null,
                            'tags' => null,
                            'objectId' => null,
                            'parameters' => null,
                            'requestBody' => null,
                            'responses' => [],
                            'callbacks' => null,
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
            function () {
                $route = RouteInformation::createFromRoute(Route::get('test', static fn () => 'test'));
                $route->actionAttributes = collect([
                    new OperationAttribute(
                        id: 'test',
                        tags: ['test'],
                        security: [],
                        method: 'post',
                        servers: [],
                        summary: 'summary',
                        description: 'description',
                        deprecated: true,
                    ),
                ]);

                return [
                    'routes' => [$route],
                    'expected' => [
                        [
                            'ref' => null,
                            'summary' => 'summary',
                            'description' => 'description',
                            'operationId' => 'test',
                            'deprecated' => true,
                            'security' => [],
                            'action' => 'post',
                            'servers' => null,
                            'tags' => null,
                            'objectId' => null,
                            'parameters' => null,
                            'requestBody' => null,
                            'responses' => [],
                            'callbacks' => null,
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
            function () {
                $route = RouteInformation::createFromRoute(Route::get('test', static fn () => 'test'));
                $route->actionAttributes = collect([
                    new Callback(CallbackFactory::class),
                    new Collection('test'),
                    new Extension(ExtensionFactory::class),
                    new OperationAttribute(
                        id: 'test',
                        tags: [TagWithExternalObjectDoc::class],
                        security: [SecuritySchemeFactory::class],
                        method: 'get',
                        servers: [ServerWithMultipleVariableFormatting::class],
                        summary: 'summary',
                        description: 'description',
                        deprecated: true,
                    ),
                    new Parameter(ParameterFactory::class),
                    new RequestBody(RequestBodyFactory::class),
                    new Response(ResponseFactory::class),
                ]);

                return [
                    'routes' => [$route],
                    'expected' => [
                        [
                            'ref' => null,
                            'summary' => 'summary',
                            'description' => 'description',
                            'operationId' => 'test',
                            'deprecated' => true,
                            // TODO: docs: it seems SecurityScheme object id is mandatory and if we dont set it,
                            //  it will be null in the SecurityRequirement object $securityScheme field
                            'security' => SecurityRequirement::create()->securityScheme((new SecuritySchemeFactory())->build()),
                            'action' => 'get',
                            'servers' => [(new ServerWithMultipleVariableFormatting())->build()],
                            'tags' => ['PostWithExternalObjectDoc'],
                            'objectId' => null,
                            'parameters' => (new ParameterFactory())->build(),
                            'requestBody' => (new RequestBodyFactory())->build(),
                            'responses' => [(new ResponseFactory())->build()],
                            'callbacks' => [(new CallbackFactory())->build()],
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
        ],
    );
})->covers(OperationBuilder::class);
