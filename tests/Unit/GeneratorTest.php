<?php

use Illuminate\Support\Facades\Config;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ServerFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\TagFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\ApiKeyLocation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeCollection;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\ApiKey;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\Http;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\OAuth2;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

beforeEach(function (): void {
    Config::set('openapi', [
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
                    (new class () extends ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://example.com');
                        }
                    })::class,
                ],
                'tags' => [
                    (new class () extends TagFactory {
                        public function build(): Tag
                        {
                            return Tag::create()
                                ->name('test');
                        }
                    })::class,
                ],
                'security' => [
                    (new class () extends SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return Http::bearer();
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
                    (new class () extends ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://test.com');
                        }
                    })::class,
                    (new class () extends ServerFactory {
                        public function build(): Server
                        {
                            return Server::create()
                                ->url('https://local.com');
                        }
                    })::class,
                ],
                'tags' => [
                    (new class () extends TagFactory {
                        public function build(): Tag
                        {
                            return Tag::create()
                                ->name('test');
                        }
                    })::class,
                ],
                'security' => [
                    (new class () extends SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return ApiKey::create('testApiKey', ApiKeyLocation::HEADER);
                        }
                    })::class,
                    (new class () extends SecuritySchemeFactory {
                        public function build(): SecurityScheme
                        {
                            return OAuth2::create(
                                Flows::create(
                                    Flows\Implicit::create(
                                        'https://example.com/oauth/authorize',
                                        'https://example.com/oauth/token',
                                        ScopeCollection::create(
                                            Scope::create('read', 'Grants read access'),
                                            Scope::create(
                                                'write',
                                                'Grants write access',
                                            ),
                                        ),
                                    ),
                                ),
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
            ->and($openApi->jsonSerialize())->toEqual($expectation);
    })->with([
        'test collection' => [
            'collection' => 'test',
            'expectation' => [
                'openapi' => OASVersion::V_3_1_0->value,
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
                'openapi' => OASVersion::V_3_1_0->value,
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
