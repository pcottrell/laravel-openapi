<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Generator;
use Tests\Doubles\Stubs\Petstore\PetController;
use Tests\Doubles\Stubs\Servers\ServerWithMultipleVariableFormatting;
use Tests\Doubles\Stubs\Servers\ServerWithoutVariables;
use Tests\Doubles\Stubs\Servers\ServerWithVariables;

describe('PetStore', function (): void {
    it(' can be generated', function (array $servers, string $path, string $method, array $expectation): void {
        Config::set('openapi.locations', [
            'schemas' => [
                __DIR__ . '/../Doubles/Fakes/Petstore/Schemas',
            ],
            'responses' => [
                __DIR__ . '/../Doubles/Fakes/Petstore/Responses/Response',
            ],
        ]);

        putenv('APP_URL=https://petstore.swagger.io/v1');
        Route::get('/pets', [PetController::class, 'index']);
        Route::post('/multiPetTag', [PetController::class, 'multiPetTag']);
        Route::delete('/nestedSecurityFirstTest', [PetController::class, 'nestedSecurityFirst']);
        Route::put('/nestedSecuritySecondTest', [PetController::class, 'nestedSecuritySecond']);

        Config::set('openapi.collections.default.servers', $servers['classes']);
        $spec = app(Generator::class)->generate()->asArray();

        expect($spec['servers'])->toBe($servers['expectation'])
            ->and($spec['paths'])->toHaveKey($path)
            ->and($spec['paths'][$path])->toHaveKey($method)
            ->and($spec['paths'][$path][$method])->toBe($expectation)
            ->and($spec)->toHaveKey('components')
            ->and($spec['components'])->toHaveKey('schemas')
            ->and($spec['components']['schemas'])->toHaveKey('PetSchema')
            ->and($spec['components']['schemas']['PetSchema'])->toBe([
                'type' => 'object',
                'required' => [
                    'id',
                    'name',
                ],
                'properties' => [
                    'id' => [
                        'format' => 'int64',
                        'type' => 'integer',
                    ],
                    'name' => [
                        'type' => 'string',
                    ],
                    'tag' => [
                        'type' => 'string',
                    ],
                ],
            ])
            ->and($spec['components'])->toHaveKey('responses')
            ->and($spec['components']['responses'])->toHaveKey('ReusableComponentErrorValidationResponse')
            ->and($spec['components']['responses']['ReusableComponentErrorValidationResponse'])->toBe([
                'description' => 'Unprocessable Entity',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'message' => [
                                    'type' => 'string',
                                    'example' => 'The given data was invalid.',
                                ],
                                'errors' => [
                                    'type' => 'object',
                                    'additionalProperties' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                    'example' => [
                                        'field' => [
                                            'Something is wrong with this field!',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    })->with([
        [
            'servers' => [
                'classes' => [ServerWithoutVariables::class],
                'expectation' => [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                    ],
                ],
            ],
            'path' => '/pets',
            'method' => 'get',
            'expectation' => [
                'tags' => [
                    'Pet',
                ],
                'summary' => 'List all pets.',
                'description' => 'List all pets from the database.',
                'operationId' => 'listPets',
                'parameters' => [
                    [
                        'name' => 'limit',
                        'in' => 'query',
                        'description' => 'How many items to return at one time (max 100)',
                        'required' => false,
                        'schema' => [
                            'format' => 'int32',
                            'type' => 'integer',
                        ],
                    ],
                ],
                'responses' => [
                    422 => [
                        '$ref' => '#/components/responses/ReusableComponentErrorValidationResponse',
                    ],
                ],
                'deprecated' => true,
            ],
        ],
        [
            'servers' => [
                'classes' => [ServerWithVariables::class],
                'expectation' => [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/multiPetTag',
            'method' => 'post',
            'expectation' => [
                'tags' => [
                    'Pet',
                    'AnotherPet',
                ],
                'summary' => 'List all pets.',
                'description' => 'List all pets from the database.',
                'operationId' => 'multiPetTag',
                'parameters' => [
                    [
                        'name' => 'limit',
                        'in' => 'query',
                        'description' => 'How many items to return at one time (max 100)',
                        'required' => false,
                        'schema' => [
                            'format' => 'int32',
                            'type' => 'integer',
                        ],
                    ],
                ],
                'responses' => [
                    422 => [
                        '$ref' => '#/components/responses/ReusableComponentErrorValidationResponse',
                    ],
                    403 => [
                        'description' => 'Forbidden',
                    ],
                ],
                'deprecated' => false,
                'security' => [
                    [
                        'ExampleHTTPBearerSecurityScheme' => [],
                    ],
                ],
            ],
        ],
        [
            'servers' => [
                'classes' => [ServerWithMultipleVariableFormatting::class],
                'expectation' => [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'ServerVariableA' => [
                                'enum' => ['A', 'B'],
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                            'ServerVariableB' => [
                                'default' => 'sample',
                                'description' => 'sample',
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/nestedSecurityFirstTest',
            'method' => 'delete',
            'expectation' => [
                'tags' => [
                    'Pet',
                ],
                'summary' => 'List all pets.',
                'description' => 'List all pets from the database.',
                'operationId' => 'nestedSecurityFirstTest',
                'parameters' => [
                    [
                        'name' => 'limit',
                        'in' => 'query',
                        'description' => 'How many items to return at one time (max 100)',
                        'required' => false,
                        'schema' => [
                            'format' => 'int32',
                            'type' => 'integer',
                        ],
                    ],
                ],
                'responses' => [
                    422 => [
                        'description' => 'Unprocessable Entity',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'The given data was invalid.',
                                        ],
                                        'errors' => [
                                            'type' => 'object',
                                            'additionalProperties' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'string',
                                                ],
                                            ],
                                            'example' => [
                                                'field' => [
                                                    'Something is wrong with this field!',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'security' => [
                    [
                        'ExampleHTTPBearerSecurityScheme' => [],
                    ],
                    [
                        'ExampleApiKeySecurityScheme' => [],
                    ],
                ],
            ],
        ],
        [
            'servers' => [
                'classes' => [ServerWithVariables::class, ServerWithMultipleVariableFormatting::class],
                'expectation' => [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                        ],
                    ],
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'ServerVariableA' => [
                                'enum' => ['A', 'B'],
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                            'ServerVariableB' => [
                                'default' => 'sample',
                                'description' => 'sample',
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/nestedSecuritySecondTest',
            'method' => 'put',
            'expectation' => [
                'tags' => [
                    'AnotherPet',
                ],
                'summary' => 'List all pets.',
                'description' => 'List all pets from the database.',
                'operationId' => 'nestedSecuritySecondTest',
                'responses' => [
                    'default' => [
                        'description' => 'Default Response',
                    ],
                ],
                'security' => [
                    [
                        'ExampleHTTPBearerSecurityScheme' => [],
                    ],
                    [
                        'ExampleHTTPBearerSecurityScheme' => [],
                        'OAuth2Password' => [
                            'order:shipping:address',
                            'order:shipping:status',
                        ],
                    ],
                ],
            ],
        ],
    ]);
})->coversNothing();
