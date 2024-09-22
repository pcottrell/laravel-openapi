<?php

use MohammadAlavi\LaravelOpenApi\oooas\Services\JsonSchemaValidator;

describe('JsonSchemaValidator', function (): void {
    it('can validate against OAS', function (array $data, bool $expectation30x, bool $expectation31x): void {
        $validator = JsonSchemaValidator::againstOAS30x($data);
        expect($validator)->toBeInstanceOf(JsonSchemaValidator::class);
        $result = $validator->validate();
        expect($result->isValid())->toBe($expectation30x);

        $validator = JsonSchemaValidator::againstOAS31x($data);
        expect($validator)->toBeInstanceOf(JsonSchemaValidator::class);
        $result = $validator->validate();
        expect($result->isValid())->toBe($expectation31x);
    })->with([
        '3.0.x' => [
            [
                'openapi' => '3.0.3',
                'info' => [
                    'title' => 'Minimal 3.0.x Spec',
                    'version' => '1.0.0',
                ],
                'paths' => [
                    '/example' => [
                        'get' => [
                            'responses' => [
                                '200' => [
                                    'description' => 'Successful response',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                'type' => 'string',
                                                'nullable' => true,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], true, true],
        '3.1.0' => [
            [
                'openapi' => '3.1.0',
                'info' => [
                    'title' => 'Minimal 3.1.0 Spec',
                    'version' => '1.0.0',
                ],
                'paths' => [
                    '/example' => [
                        'get' => [
                            'responses' => [
                                '200' => [
                                    'description' => 'Successful response',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                'type' => ['string', 'null'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ], false, true],
    ]);

    it('can set a custom JSON schema', function (): void {
        $data = [
            'test' => 'value',
        ];
        $schemaA = (object) [
            'type' => 'object',
            'properties' => (object) [
                'test' => (object) [
                    'type' => 'string',
                ],
            ],
            'required' => ['test'],
        ];

        $result = JsonSchemaValidator::new($data, $schemaA)->validate();
        expect($result->isValid())->toBeTrue();

        $schemaB = (object) [
            'type' => 'object',
            'properties' => (object) [
                'test' => (object) [
                    'type' => 'integer',
                ],
            ],
            'required' => ['test'],
        ];

        $result = $result->against($schemaB)->validate();
        expect($result->isValid())->toBeFalse()
            ->and($result->errors())->toBeArray()
            ->and($result->errors())->not->toBeEmpty();
    });

    it('can decode json from file', function (): void {
        $schema = JsonSchemaValidator::jsonFromFile(realpath(__DIR__ . '/../../../../src/oooas/Schemas/v3.0.x.json'));
        expect($schema)->toBeInstanceOf(stdClass::class);
    });
})->covers(JsonSchemaValidator::class);
