<?php

namespace Vyuldashev\LaravelOpenApi\Tests;

use Examples\Petstore\PetController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Vyuldashev\LaravelOpenApi\Tests\Builders\ServerWithMultipleVariableFormatting;
use Vyuldashev\LaravelOpenApi\Tests\Builders\ServerWithoutVariables;
use Vyuldashev\LaravelOpenApi\Tests\Builders\ServerWithVariables;

/**
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/examples/v3.0/petstore.yaml
 */
class PetstoreTest extends TestCase
{
    public function expectationProvider()
    {
        return [
            [
                'servers' => [
                    'classes' => [ServerWithoutVariables::class],
                    'expectation' => [
                        [
                            'url' => 'http://example.com',
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
                            '$ref' => '#/components/responses/ErrorValidation',
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
                            'url' => 'http://example.com',
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
                            '$ref' => '#/components/responses/ErrorValidation',
                        ],
                    ],
                    'deprecated' => false,
                    'security' => [
                        [
                            'BearerToken' => [],
                        ],
                    ],
                ],
            ],
            [
                'servers' => [
                    'classes' => [ServerWithMultipleVariableFormatting::class],
                    'expectation' => [
                        [
                            'url' => 'http://example.com',
                            'description' => 'sample_description',
                            'variables' => [
                                'variable_name' => [
                                    'enum' => ['A', 'B'],
                                    'default' => 'variable_defalut',
                                    'description' => 'variable_description',
                                ],
                                'variable_name_B' => [
                                    'default' => 'sample',
                                    'description' => 'sample',
                                ],
                            ],
                        ],
                    ],
                ],
                'path' => '/multiAuthSecurityFirstTest',
                'method' => 'delete',
                'expectation' => [
                    'tags' => [
                        'Pet',
                    ],
                    'summary' => 'List all pets.',
                    'description' => 'List all pets from the database.',
                    'operationId' => 'multiAuthSecurityFirstTest',
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
                    'security' => [
                        [
                            'OAuth2PasswordGrant' => [],
                        ],
                        [
                            'BearerToken' => [],
                        ],
                    ],
                ],
            ],
            [
                'servers' => [
                    'classes' => [ServerWithVariables::class, ServerWithMultipleVariableFormatting::class],
                    'expectation' => [
                        [
                            'url' => 'http://example.com',
                            'description' => 'sample_description',
                            'variables' => [
                                'variable_name' => [
                                    'default' => 'variable_defalut',
                                    'description' => 'variable_description',
                                ],
                            ],
                        ],
                        [
                            'url' => 'http://example.com',
                            'description' => 'sample_description',
                            'variables' => [
                                'variable_name' => [
                                    'enum' => ['A', 'B'],
                                    'default' => 'variable_defalut',
                                    'description' => 'variable_description',
                                ],
                                'variable_name_B' => [
                                    'default' => 'sample',
                                    'description' => 'sample',
                                ],
                            ],
                        ],
                    ],
                ],
                'path' => '/multiAuthSecuritySecondTest',
                'method' => 'put',
                'expectation' => [
                    'tags' => [
                        'AnotherPet',
                    ],
                    'summary' => 'List all pets.',
                    'description' => 'List all pets from the database.',
                    'operationId' => 'multiAuthSecuritySecondTest',
                    'security' => [
                        [
                            'BearerToken' => [],
                        ],
                        [
                            'OAuth2PasswordGrant' => [],
                            'BearerToken' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider expectationProvider
     */
    public function testGenerate(array $servers, string $path, string $method, array $expectation): void
    {
        Config::set('openapi.collections.default.servers', $servers['classes']);
        $spec = $this->generate()->toArray();

        self::assertSame($servers['expectation'], $spec['servers']);

        self::assertArrayHasKey($path, $spec['paths']);
        self::assertArrayHasKey($method, $spec['paths'][$path]);

        self::assertSame($expectation, $spec['paths'][$path][$method]);

        self::assertArrayHasKey('components', $spec);
        self::assertArrayHasKey('schemas', $spec['components']);
        self::assertArrayHasKey('Pet', $spec['components']['schemas']);

        self::assertSame([
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
        ], $spec['components']['schemas']['Pet']);
    }

    protected function setUp(): void
    {
        putenv('APP_URL=http://petstore.swagger.io/v1');

        parent::setUp();

        Route::get('/pets', [PetController::class, 'index']);
        Route::post('/multiPetTag', [PetController::class, 'multiPetTag']);
        Route::delete('/multiAuthSecurityFirstTest', [PetController::class, 'multiAuthSecurityFirstTest']);
        Route::put('/multiAuthSecuritySecondTest', [PetController::class, 'multiAuthSecuritySecondTest']);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('openapi.locations.schemas', [
            __DIR__ . '/../examples/petstore/OpenApi/Schemas',
        ]);
    }
}
