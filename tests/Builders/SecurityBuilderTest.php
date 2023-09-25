<?php

namespace Vyuldashev\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Components;
use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes\Operation as AttributesOperation;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\SecurityRequirementBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\OperationBuilder;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Objects\OpenApi;
use Vyuldashev\LaravelOpenApi\Objects\Operation;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\RouteInformation;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\SkipGlobalSecurityScheme;
use Vyuldashev\LaravelOpenApi\Tests\TestCase;

class SecurityBuilderTest extends TestCase
{
    public function operationSecuritySchemesDataProvider(): array
    {
        return [
            // Test scenario 1: JWT authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                ],
                JwtSecurityScheme::class,
            ],
            // Test scenario 2: ApiKeyAuth authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                ApiKeySecurityScheme::class,
            ],
            // Test scenario 3: Both JWT and ApiKeyAuth authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                [
                    [
                        JwtSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
            // Test scenario 4: Either JWT or ApiKeyAuth authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                [
                    [
                        JwtSecurityScheme::class,
                    ],
                    [
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
            // Test scenario 5: Either JWT & ApiKeyAuth or BearerAuth authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'BearerAuth' => $this->bearerAuthSecuritySchemeProvider(),
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'BearerAuth' => [],
                        ],
                        [
                            'JWT' => [],
                            'BearerAuth' => [],
                        ],
                        [
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                [
                    [
                        BearerSecurityScheme::class,
                    ],
                    [
                        JwtSecurityScheme::class,
                        BearerSecurityScheme::class,
                    ],
                    [
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider operationSecuritySchemesDataProvider
     */
    public function testCanApplyMultipleSecuritySchemesOnOperation(array $expectedJson, array|string $securitySchemesClass): void
    {
        $components = Components::create();
        $securitySchemes = [];

        if (is_array($securitySchemesClass)) {
            array_walk_recursive($securitySchemesClass, static function ($securityScheme) use (&$securitySchemes) {
                $securityScheme = app($securityScheme)->build();
                $securitySchemes[] = $securityScheme;
            });
        } else {
            $securityScheme = app($securitySchemesClass)->build();
            $securitySchemes[] = $securityScheme;
        }
        $components = $components->securitySchemes(...$securitySchemes);

        $action = 'get';
        $routeInfo = app(RouteInformation::class);
        $routeInfo->parameters = collect();
        $routeInfo->method = 'get';
        $routeInfo->action = $action;
        $routeInfo->name = 'test route';
        $routeInfo->actionAttributes = collect([
            new AttributesOperation(security: $securitySchemesClass),
        ]);
        $routeInfo->uri = '/example';
        $operation = app(OperationBuilder::class)->build([$routeInfo])[0];
        $openApi = OpenApi::create();

        $openApi = $openApi
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        // Assert that the generated JSON matches the expected JSON for this scenario
        self::assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [
                        'security' => $expectedJson['security'],
                    ],
                ],
            ], 'components' => $expectedJson['components'],
        ], $openApi->toArray());
    }

    public function globalSecuritySchemesDataProvider(): array
    {
        return [
            // Test scenario 1: JWT authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                ],
                JwtSecurityScheme::class,
            ],
            // Test scenario 2: ApiKeyAuth authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                ApiKeySecurityScheme::class,
            ],
            // Test scenario 3: Both JWT and ApiKeyAuth authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                [
                    [
                        JwtSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
            // Test scenario 4: Either JWT or ApiKeyAuth authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKeyAuth' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKeyAuth' => [],
                        ],
                    ],
                ],
                [
                    [
                        JwtSecurityScheme::class,
                    ],
                    [
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider globalSecuritySchemesDataProvider
     */
    public function testCanApplyMultipleSecuritySchemesGlobaly(array $expectedJson, array|string $securitySchemesClass): void
    {
        $components = Components::create();
        $securitySchemes = [];

        if (is_array($securitySchemesClass)) {
            array_walk_recursive($securitySchemesClass, static function ($securityScheme) use (&$securitySchemes) {
                $securityScheme = app($securityScheme)->build();
                $securitySchemes[] = $securityScheme;
            });
        } else {
            $securityScheme = app($securitySchemesClass)->build();
            $securitySchemes[] = $securityScheme;
        }
        $components = $components->securitySchemes(...$securitySchemes);

        $routeInfo = app(RouteInformation::class);
        $routeInfo->actionAttributes = collect([
            new AttributesOperation(security: $securitySchemesClass),
        ]);
        $globalRequirement = app(SecurityRequirementBuilder::class)->build($routeInfo);

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->security($globalRequirement)
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        // Assert that the generated JSON matches the expected JSON for this scenario
        self::assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [
                    ],
                ],
            ],
            'components' => $expectedJson['components'],
            'security' => $expectedJson['security'],
        ], $openApi->toArray());
    }

    /**
     * We're just making sure we're getting the expected output.
     */
    public function testWeCanBuildUpTheSecurityScheme(): void
    {
        $securityFactory = app(JwtSecurityScheme::class);
        $testJwtScheme = $securityFactory->build();

        $globalRequirement = SecurityRequirement::create('JWT')
            ->securityScheme($testJwtScheme);

        $components = Components::create()
            ->securitySchemes($testJwtScheme);

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->security($globalRequirement)
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        self::assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [],
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'JWT' => $this->JwtSecuritySchemeProvider(),
                ],
            ],
            'security' => [
                [
                    'JWT' => [],
                ],
            ],
        ], $openApi->toArray());
    }

    /**
     * We're just verifying that the builder is capable of
     * adding security information to the operation.
     */
    public function testWeCanAddOperationSecurityUsingBuilder()
    {
        $securityFactory = app(JwtSecurityScheme::class);
        $testJwtScheme = $securityFactory->build();

        $components = Components::create()
            ->securitySchemes($testJwtScheme);

        $routeInfo = new RouteInformation();
        $routeInfo->action = 'get';
        $routeInfo->name = 'test route';
        $routeInfo->actionAttributes = collect([
            new AttributesOperation(security: JwtSecurityScheme::class),
        ]);
        $routeInfo->uri = '/example';

        /** @var SecurityRequirementBuilder */
        $builder = app(SecurityRequirementBuilder::class);

        $operation = Operation::create()
            ->security($builder->build($routeInfo))
            ->action('get');

        $openApi = OpenApi::create()
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        self::assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [
                        'security' => [
                            [
                                'JWT' => [],
                            ],
                        ],
                    ],
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'JWT' => $this->JwtSecuritySchemeProvider(),
                ],
            ],
        ], $openApi->toArray());
    }

    /**
     * He's the main part of the PR. It's not possible to turn
     * off security for an operation.
     */
    public function testWeCanAddTurnOffOperationSecurityUsingBuilder()
    {
        $securityFactory = app(JwtSecurityScheme::class);
        $testJwtScheme = $securityFactory->build();

        $globalRequirement = SecurityRequirement::create('JWT')
            ->securityScheme($testJwtScheme);

        $components = Components::create()
            ->securitySchemes($testJwtScheme);

        $routeInfo = new RouteInformation();
        $routeInfo->parameters = collect();
        $routeInfo->action = 'foo';
        $routeInfo->method = 'get';
        $routeInfo->name = 'test route';
        $routeInfo->actionAttributes = collect([
            new AttributesOperation(security: SkipGlobalSecurityScheme::class),
        ]);

        /** @var OperationBuilder */
        $operationBuilder = app(OperationBuilder::class);

        $operations = $operationBuilder->build([$routeInfo]);

        $openApi = OpenApi::create()
            ->security($globalRequirement)
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations(...$operations)
            );

        self::assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [],
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'JWT' => $this->JwtSecuritySchemeProvider(),
                ],
            ],
            'security' => [
                [
                    'JWT' => [],
                ],
            ],
        ], $openApi->toArray());
    }

    /**
     * @return string[]
     */
    private function JwtSecuritySchemeProvider(): array
    {
        return [
            'type' => 'http',
            'name' => 'JwtTestScheme',
            'in' => 'header',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT',
        ];
    }

    /**
     * @return string[]
     */
    private function apiKeyAuthSecuritySchemeProvider(): array
    {
        return [
            'type' => 'apiKey',
            'name' => 'X-API-KEY',
            'in' => 'header',
            'scheme' => 'apiKey',
        ];
    }

    /**
     * @return string[]
     */
    private function bearerAuthSecuritySchemeProvider(): array
    {
        return [
            'type' => 'http',
            'scheme' => 'bearer',
        ];
    }
}

class JwtSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('JWT')
            ->name('JwtTestScheme')
            ->type(SecurityScheme::TYPE_HTTP)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('bearer')
            ->bearerFormat('JWT');
    }
}

class ApiKeySecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('ApiKeyAuth')
            ->name('X-API-KEY')
            ->type(SecurityScheme::TYPE_API_KEY)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('apiKey');
    }
}

class BearerSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerAuth')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
