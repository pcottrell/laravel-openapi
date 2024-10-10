<?php

use Illuminate\Support\Facades\Config;
use MohammadAlavi\LaravelOpenApi\Builders\Components\ComponentsBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;
use Pest\Expectation;

describe('ComponentsBuilder', function (): void {
    beforeEach(function (): void {
        Config::set('openapi', [
            'collections' => [
                'test' => [
                    'security' => [
                        (new class () extends SecuritySchemeFactory {
                            public function build(): SecurityScheme
                            {
                                return SecurityScheme::create()
                                    ->type('http')
                                    ->scheme('bearer');
                            }
                        })::class,
                    ],
                ],
            ],
            'locations' => [
                'callbacks' => [
                    __DIR__ . '/../../Doubles/Stubs/Collectors/Components/Callback',
                ],
                'request_bodies' => [
                    __DIR__ . '/../../Doubles/Stubs/Collectors/Components/RequestBody',
                ],
                'responses' => [
                    __DIR__ . '/../../Doubles/Stubs/Collectors/Components/Response',
                ],
                'schemas' => [
                    __DIR__ . '/../../Doubles/Stubs/Collectors/Components/Schema',
                ],
                'security' => [
                    __DIR__ . '/../../Doubles/Stubs/Collectors/Components/SecurityScheme',
                ],
            ],
        ]);
    });

    it('can collect components', function (string|null $collection, array|null $expectation): void {
        $builder = app(ComponentsBuilder::class);

        $result = $builder->build($collection);

        expect($result)->unless(
            is_null($result),
            fn (Expectation $xp): Expectation => $xp->toBeInstanceOf(Components::class)
                ->and($xp->value->jsonSerialize())->toEqual($expectation),
        );
    })->with(
        [
            'none existing collection' => [
                'collection' => 'unknown',
                'expectation' => null,
            ],
            'test collection' => [
                'collection' => 'test',
                'expectation' => [
                    'schemas' => [
                        'test collection Schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        'ExplicitCollectionResponse' => [],
                        'MultiCollectionResponse' => [],
                    ],
                    'requestBodies' => [
                        'MultiCollectionRequestBody' => [],
                        'ExplicitCollectionRequestBody' => [],
                    ],
                    'callbacks' => [
                        'ExplicitCollectionCallback' => [],
                        'MultiCollectionCallback' => [],
                    ],
                ],
            ],
            'explicit default collection' => [
                'collection' => Generator::COLLECTION_DEFAULT,
                'expectation' => [
                    'schemas' => [
                        'default collection Schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                        'test collection Schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        'ImplicitCollectionResponse' => [],
                        'MultiCollectionResponse' => [],
                    ],
                    'requestBodies' => [
                        'MultiCollectionRequestBody' => [],
                        'ImplicitCollectionRequestBody' => [],
                    ],
                    'callbacks' => [
                        'ImplicitCollectionCallback' => [],
                        'MultiCollectionCallback' => [],
                    ],
                ],
            ],
        ],
    );
})->covers(ComponentsBuilder::class);
