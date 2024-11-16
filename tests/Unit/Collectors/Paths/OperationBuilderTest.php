<?php

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use MohammadAlavi\LaravelOpenApi\Attributes\Responses;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInfo;
use Tests\Doubles\Stubs\Attributes\CallbackFactory;
use Tests\Doubles\Stubs\Attributes\ExtensionFactory;
use Tests\Doubles\Stubs\Attributes\ParameterFactory;
use Tests\Doubles\Stubs\Attributes\RequestBodyFactory;
use Tests\Doubles\Stubs\Attributes\ResponsesFactory;
use Tests\Doubles\Stubs\Petstore\Security\ExampleSingleSecurityRequirementSecurity;
use Tests\Doubles\Stubs\Servers\ServerWithMultipleVariableFormatting;
use Tests\Doubles\Stubs\Tags\TagWithExternalObjectDoc;

describe('OperationBuilder', function (): void {
    it('can be created in many combinations', function (RouteInfo $routeInfo, array $expected): void {
        $operationBuilder = app(OperationBuilder::class);

        $operation = $operationBuilder->build($routeInfo);

        expect($operation->method)->toBe($expected[0]['action'])
            ->and($operation->tags)->toBe($expected[0]['tags'])
            ->and($operation->summary)->toBe($expected[0]['summary'])
            ->and($operation->description)->toBe($expected[0]['description'])
            ->and($operation->externalDocs)->toBe($expected[0]['externalDocs'])
            ->and($operation->operationId)->toBe($expected[0]['operationId'])
            ->and($operation->parameterCollection)->toEqual($expected[0]['parameters'])
            ->and($operation->requestBody)->toEqual($expected[0]['requestBody'])
            ->and($operation->responses)->toEqual($expected[0]['responses'])
            ->and($operation->deprecated)->toBe($expected[0]['deprecated'])
            ->and($operation->security)->toEqual($expected[0]['security'])
            ->and($operation->servers)->toEqual($expected[0]['servers'])
            ->and($operation->callbacks)->toEqual($expected[0]['callbacks']);
    })->with(
        [
            function (): array {
                $routeInformation = RouteInfo::create(
                    Route::get('test', static fn (): string => 'test'),
                );
                $routeInformation->actionAttributes = collect([
                    new OperationAttribute(
                        id: 'test',
                        tags: [],
                        security: null,
                        method: 'get',
                        servers: [],
                        summary: '',
                        description: '',
                        deprecated: false,
                    ),
                ]);

                return [
                    'routes' => $routeInformation,
                    'expected' => [
                        [
                            'summary' => '',
                            'description' => '',
                            'operationId' => 'test',
                            'deprecated' => false,
                            'security' => null,
                            'action' => 'get',
                            'servers' => null,
                            'tags' => null,
                            'parameters' => null,
                            'requestBody' => null,
                            'responses' => null,
                            'callbacks' => null,
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
            function (): array {
                $routeInformation = RouteInfo::create(
                    Route::get('test', static fn (): string => 'test'),
                );
                $routeInformation->actionAttributes = collect([
                    new OperationAttribute(
                        id: 'test',
                        tags: ['test'],
                        security: null,
                        method: 'post',
                        servers: [],
                        summary: 'summary',
                        description: 'description',
                        deprecated: true,
                    ),
                ]);

                return [
                    'routes' => $routeInformation,
                    'expected' => [
                        [
                            'summary' => 'summary',
                            'description' => 'description',
                            'operationId' => 'test',
                            'deprecated' => true,
                            'security' => null,
                            'action' => 'post',
                            'servers' => null,
                            'tags' => null,
                            'parameters' => null,
                            'requestBody' => null,
                            'responses' => null,
                            'callbacks' => null,
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
            function (): array {
                $routeInformation = RouteInfo::create(
                    Route::get('test', static fn (): string => 'test'),
                );
                $routeInformation->actionAttributes = collect([
                    new Callback(CallbackFactory::class),
                    new Collection('test'),
                    new Extension(ExtensionFactory::class),
                    new OperationAttribute(
                        id: 'test',
                        tags: [TagWithExternalObjectDoc::class],
                        security: ExampleSingleSecurityRequirementSecurity::class,
                        method: 'get',
                        servers: [ServerWithMultipleVariableFormatting::class],
                        summary: 'summary',
                        description: 'description',
                        deprecated: true,
                    ),
                    new Parameters(ParameterFactory::class),
                    new RequestBody(RequestBodyFactory::class),
                    new Responses(ResponsesFactory::class),
                ]);

                return [
                    'routes' => $routeInformation,
                    'expected' => [
                        [
                            'summary' => 'summary',
                            'description' => 'description',
                            'operationId' => 'test',
                            'deprecated' => true,
                            // TODO: docs: it seems SecurityScheme object id is mandatory and if we dont set it,
                            //  it will be null in the SecurityRequirement object $securityScheme field
                            //  Based on OAS spec security requirement cant not have a name
                            'security' => (new ExampleSingleSecurityRequirementSecurity())->build(),
                            'action' => 'get',
                            'servers' => [(new ServerWithMultipleVariableFormatting())->build()],
                            'tags' => ['PostWithExternalObjectDoc'],
                            'parameters' => (new ParameterFactory())->build(),
                            'requestBody' => (new RequestBodyFactory())->build(),
                            'responses' => (new ResponsesFactory())->build(),
                            'callbacks' => [(new CallbackFactory())->build()],
                            'externalDocs' => null,
                        ],
                    ],
                ];
            },
        ],
    );
})->covers(OperationBuilder::class);
