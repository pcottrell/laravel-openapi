<?php

use Illuminate\Support\Facades\Config;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Collectors\ComponentCollector;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use Pest\Expectation;

describe('ComponentCollector', function (): void {
    beforeEach(function (): void {
        Config::set('openapi', [
            'collections' => [
                'test' => [
                    'security' => [
                        (new class () extends SecuritySchemeFactory {
                            public function build(): SecurityScheme
                            {
                                return SecurityScheme::create('bearerAuth')
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
        $componentCollector = app(ComponentCollector::class);

        $result = $componentCollector->collect($collection);

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
                        'test collection Response' => [],
                    ],
                    'requestBodies' => [
                        'test collection RequestBody' => [],
                    ],
                    'callbacks' => [
                        'test collection PathItem' => [
                            '' => [],
                        ],
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
                        'test collection Response' => [],
                        'default collection Response' => [],
                    ],
                    'requestBodies' => [
                        'test collection RequestBody' => [],
                        'default collection RequestBody' => [],
                    ],
                    'callbacks' => [
                        'test collection PathItem' => [
                            '' => [],
                        ],
                        'default collection PathItem' => [
                            '' => [],
                        ],
                    ],
                ],
            ],
            'used default collection if no collection passed' => [
                'collection' => null,
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
                        'test collection Response' => [],
                        'default collection Response' => [],
                    ],
                    'requestBodies' => [
                        'test collection RequestBody' => [],
                        'default collection RequestBody' => [],
                    ],
                    'callbacks' => [
                        'test collection PathItem' => [
                            '' => [],
                        ],
                        'default collection PathItem' => [
                            '' => [],
                        ],
                    ],
                ],
            ],
        ],
    );
})->covers(ComponentCollector::class);
