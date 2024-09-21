<?php

use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOAS\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

beforeEach(function (): void {
    Illuminate\Support\Facades\Config::set('openapi', [
        'collections' => [
            'default' => [
                'info' => [
                    'title' => 'Test Default API',
                    'description' => 'Test Default API description',
                    'version' => '1.0.0',
                    'contact' => [
                        'name' => 'Mohammad Alavi',
                    ],
                ],
                'servers' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://example.com');
                        }
                    })::class,
                ],
                'tags' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\TagFactory {
                        public function build(): Tag
                        {
                            return Tag::create()
                                ->name('test');
                        }
                    })::class,
                ],
                'security' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return SecurityScheme::create('bearerAuth')
                                ->type('http')
                                ->scheme('bearer');
                        }
                    })::class,
                ],
                'middlewares' => [
                    'paths' => [],
                    'components' => [],
                ],
            ],
            'test' => [
                'info' => [
                    'title' => 'Test API',
                    'description' => 'Test API description',
                    'version' => '2.0.0',
                    'contact' => [
                        'name' => 'Mohammad Alavi the second',
                    ],
                ],
                'servers' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://test.com');
                        }
                    })::class,
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://local.com');
                        }
                    })::class,
                ],
                'tags' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\TagFactory {
                        public function build(): Tag
                        {
                            return Tag::create()
                                ->name('test');
                        }
                    })::class,
                ],
                'security' => [
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return SecurityScheme::create('apiKey')
                                ->type('apiKey')
                                ->in('header');
                        }
                    })::class,
                    (new class () extends MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return SecurityScheme::oauth2('oauth2')
                                ->flows(
                                    OAuthFlow::create('oauth2')
                                    ->authorizationUrl('https://example.com/oauth/authorize')
                                    ->tokenUrl('https://example.com/oauth/token')
                                    ->scopes([
                                        'read' => 'Grants read access',
                                        'write' => 'Grants write access',
                                    ]),
                                );
                        }
                    })::class,
                ],
                'extensions' => [
                    'x-tagGroups' => [
                        [
                            'name' => 'General',
                            'tags' => [
                                'user',
                            ],
                        ],
                    ],
                ],
                //                'middlewares' => [
                //                    'components' => [
                //                        'schemas' => [
                //                            'Test' => [
                //                                'type' => 'object',
                //                                'properties' => [
                //                                    'id' => [
                //                                        'type' => 'integer',
                //                                    ],
                //                                ],
                //                            ],
                //                        ],
                //                    ],
                //                ],
            ],
        ],
        'locations' => [
            'callbacks' => [
                __DIR__ . '/../Doubles/Stubs/Collectors/Components/Callback',
            ],
            'request_bodies' => [
                __DIR__ . '/../Doubles/Stubs/Collectors/Components/RequestBody',
            ],
            'responses' => [
                __DIR__ . '/../Doubles/Stubs/Collectors/Components/Response',
            ],
            'schemas' => [
                __DIR__ . '/../Doubles/Stubs/Collectors/Components/Schema',
            ],
            'security' => [
                __DIR__ . '/../Doubles/Stubs/Collectors/Components/SecurityScheme',
            ],
        ],
    ]);
});

describe('Generator', function (): void {
    it('should generate OpenApi object', function (string $collection, array $expectation): void {
        $generator = app(Generator::class);

        $openApi = $generator->generate($collection);

        expect($openApi)->toBeInstanceOf(OpenApi::class)
            ->and($openApi->toArray())->toBe($expectation);
    })->with([
        'test collection' => [
            'collection' => 'test',
            'expectation' => [
                'openapi' => '3.1.0',
                'info' => [
                    'title' => 'Test API',
                    'description' => 'Test API description',
                    'contact' => [
                        'name' => 'Mohammad Alavi the second',
                    ],
                    'version' => '2.0.0',
                ],
                'servers' => [
                    [
                        'url' => 'https://test.com',
                    ],
                    [
                        'url' => 'https://local.com',
                    ],
                ],
                'components' => [
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
                'security' => [
                    [
                        'apiKey' => [],
                    ],
                    [
                        'oauth2' => [],
                    ],
                ],
                'tags' => [
                    [
                        'name' => 'test',
                    ],
                ],
                'x-tagGroups' => [
                    [
                        'name' => 'General',
                        'tags' => [
                            'user',
                        ],
                    ],
                ],
            ],
        ],
        'default collection' => [
            'collection' => Generator::COLLECTION_DEFAULT,
            'expectation' => [
                'openapi' => '3.1.0',
                'info' => [
                    'title' => 'Test Default API',
                    'description' => 'Test Default API description',
                    'contact' => [
                        'name' => 'Mohammad Alavi',
                    ],
                    'version' => '1.0.0',
                ],
                'servers' => [
                    [
                        'url' => 'https://example.com',
                    ],
                ],
                'components' => [
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
                'security' => [
                    [
                        'bearerAuth' => [],
                    ],
                ],
                'tags' => [
                    [
                        'name' => 'test',
                    ],
                ],
            ],
        ],
    ]);
})->covers(Generator::class);
