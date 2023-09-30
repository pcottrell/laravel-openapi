<?php

namespace Vyuldashev\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Components;
use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes\Operation as AttributesOperation;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\SecurityRequirementBuilder as OperationSecurityBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\OperationBuilder;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Objects\OpenApi;
use Vyuldashev\LaravelOpenApi\Objects\Operation;
use Vyuldashev\LaravelOpenApi\Objects\RouteInformation;
use Vyuldashev\LaravelOpenApi\Tests\TestCase;

class SecurityBuilderTest extends TestCase
{
    public function operationSecuritySchemesDataProvider(): array
    {
        return [
            // 0. No global security - no path security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => null,
                    'pathSecurity' => null,
                ],
                [ // available global securities (components)
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [], // applied global security
                null, // use default global securities
            ],
            // 1. Use default global security - have single class string security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => null,
                ],
                [
                    ApiKeySecurityScheme::class,
                    JwtSecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
                null,
            ],
            // 2. Use default global security - have multi-auth security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                        [
                            'ApiKey' => [],
                            'JWT' => [],
                        ],
                        [
                            'Bearer' => [],
                        ],
                        [
                            'Bearer' => [],
                            'ApiKey' => [],
                        ],
                        [
                            'Bearer' => [],
                            'ApiKey' => [],
                            'JWT' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => null,
                ],
                [
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                    JwtSecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                    [
                        ApiKeySecurityScheme::class,
                        JwtSecurityScheme::class,
                    ],
                    BearerSecurityScheme::class,
                    [
                        BearerSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                    ],
                    [
                        BearerSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                        JwtSecurityScheme::class,
                    ],
                    [
                        // TODO: should this duplication be removed?
                        // I don't think it is removed automatically.
                        ApiKeySecurityScheme::class,
                    ],
                ],
                null,
            ],
            // 3. Override global security - disable global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => [],
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
                [],
            ],
            // 4. Override global security - with same security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class, // available global securities (components)
                ],
                [
                    JwtSecurityScheme::class, // applied global securities
                ],
                JwtSecurityScheme::class, // security overrides
            ],
            // 5. Override global security - single auth class string
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
                JwtSecurityScheme::class,
            ],
            // 6. Override global security - single auth array
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
                [
                    JwtSecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
            ],
            // 7. Override global security - multi-auth (and) - single auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'ApiKey' => [],
                            'Bearer' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [
                    JwtSecurityScheme::class,
                ],
                [
                    [
                        ApiKeySecurityScheme::class,
                        BearerSecurityScheme::class,
                    ],
                ],
            ],
            // 8. Override global security - multi-auth (and) - multi auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'Bearer' => [],
                            'JWT' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'JWT' => [],
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [
                    [
                        BearerSecurityScheme::class,
                        JwtSecurityScheme::class,
                    ],
                ],
                [
                    [
                        JwtSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
            // 9. Override global security - multi-auth (or) - single auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'Bearer' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [
                    BearerSecurityScheme::class,
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
            // 10. Override global security - multi-auth (or) - multi auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'Bearer' => [],
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [
                    [
                        BearerSecurityScheme::class,
                        ApiKeySecurityScheme::class,
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
            // 11. Override global security - multi-auth (and + or) - single auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'ApiKey' => [],
                        ],
                        [
                            'JWT' => [],
                            'Bearer' => [],
                        ],
                    ],
                ],
                [
                    BearerSecurityScheme::class,
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
                [
                    JwtSecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                    [
                        JwtSecurityScheme::class,
                        BearerSecurityScheme::class,
                    ],
                ],
            ],
            // 12. Override global security - multi-auth (and + or) - multi auth global security
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'globalSecurity' => [
                        [
                            'Bearer' => [],
                            'ApiKey' => [],
                        ],
                    ],
                    'pathSecurity' => [
                        [
                            'Bearer' => [],
                        ],
                        [
                            'JWT' => [],
                            'Bearer' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    BearerSecurityScheme::class,
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
                [
                    [
                        BearerSecurityScheme::class,
                        ApiKeySecurityScheme::class,
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
    public function testCanApplyMultipleSecuritySchemesOnOperation(
        array $expectedJson,
        array $securitySchemeComponents,
        array $globalSecurity,
        string|array|null $pathSecurity
    ): void {
        $components = Components::create()->securitySchemes(
            ...collect($securitySchemeComponents)->map(
                static fn (string $securitySchemeFactory): SecurityScheme => app($securitySchemeFactory)->build()
            )->toArray()
        );

        $action = 'get';
        $route = '/foo';
        $routeInfo = app(RouteInformation::class);
        $routeInfo->parameters = collect();
        $routeInfo->method = $action;
        $routeInfo->action = $action;
        $routeInfo->name = 'test route';
        $routeInfo->actionAttributes = collect([
            new AttributesOperation(security: $pathSecurity),
        ]);
        $routeInfo->uri = '/example';
        $operation = app(OperationBuilder::class)->build([$routeInfo])[0];
        $openApi = OpenApi::create();

        $openApi = $openApi
            ->components($components)
            ->multiAuthSecurity($globalSecurity)
            ->paths(
                PathItem::create()
                    ->route($route)
                    ->operations($operation)
            );

        // Assert that the generated JSON matches the expected JSON for this scenario
        $actionData = [
            $action => [],
        ];
        if (!is_null($expectedJson['pathSecurity'])) {
            $actionData[$action] = ['security' => $expectedJson['pathSecurity']];
        }
        $collectionData = [
            'components' => $expectedJson['components'],
        ];
        if (!is_null($expectedJson['globalSecurity'])) {
            $collectionData['security'] = $expectedJson['globalSecurity'];
        }

        self::assertSame([
            'paths' => [
                $route => $actionData,
            ], ...$collectionData,
        ], $openApi->toArray());
    }

    public function globalSecuritySchemesDataProvider(): array
    {
        return [
            // JWT authentication only
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
                [
                    JwtSecurityScheme::class,
                ],
                [
                    [
                        JwtSecurityScheme::class,
                    ],
                ],
            ],
            // ApiKey authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
                [
                    ApiKeySecurityScheme::class,
                ],
            ],
            // Both JWT and ApiKey authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
                [
                    [
                        JwtSecurityScheme::class,
                        ApiKeySecurityScheme::class,
                    ],
                ],
            ],
            // Either JWT or ApiKey authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
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
            // And & Or combination
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => $this->JwtSecuritySchemeProvider(),
                            'ApiKey' => $this->apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => $this->bearerAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'Bearer' => [],
                        ],
                        [
                            'JWT' => [],
                            'Bearer' => [],
                        ],
                        [
                            'Bearer' => [],
                        ],
                        [
                            'JWT' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                    BearerSecurityScheme::class,
                ],
                [
                    BearerSecurityScheme::class,
                    [
                        JwtSecurityScheme::class,
                        BearerSecurityScheme::class,
                    ],
                    [
                        BearerSecurityScheme::class,
                    ],
                    JwtSecurityScheme::class,
                    [
                        ApiKeySecurityScheme::class,
                    ],
                    ApiKeySecurityScheme::class,
                ],
            ],
        ];
    }

    /**
     * @dataProvider globalSecuritySchemesDataProvider
     */
    public function testCanApplyMultipleSecuritySchemesGlobaly(
        array $expectedJson,
        array $securitySchemeComponents,
        array $globalSecurity,
    ): void {
        $components = Components::create()->securitySchemes(
            ...collect($securitySchemeComponents)->map(
                static fn (string $securitySchemeFactory): SecurityScheme => app($securitySchemeFactory)->build()
            )->toArray()
        );

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->multiAuthSecurity($globalSecurity)
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        // Assert that the generated JSON matches the expected JSON for this scenario
        $expected = [
            'paths' => [
                '/foo' => [
                    'get' => [
                    ],
                ],
            ],
            'components' => $expectedJson['components'],
            'security' => $expectedJson['security'],
        ];
        self::assertSame($expected, $openApi->toArray());
        self::assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
    }

    /**
     * We're just making sure we're getting the expected output.
     */
    public function testCanBuildUpTheSecurityScheme(): void
    {
        $securityFactory = app(JwtSecurityScheme::class);
        $testJwtScheme = $securityFactory->build();

        $components = Components::create()
            ->securitySchemes($testJwtScheme);

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->multiAuthSecurity([JwtSecurityScheme::class])
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        $expected = [
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
        ];
        self::assertSame($expected, $openApi->toArray());
        self::assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
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

        /** @var OperationSecurityBuilder */
        $builder = app(OperationSecurityBuilder::class);

        $operation = Operation::create()
            ->security($builder->build($routeInfo->actionAttributes[0]->security))
            ->action('get');

        $openApi = OpenApi::create()
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        $expected = [
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
        ];
        self::assertSame($expected, $openApi->toArray());
        self::assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
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
        return SecurityScheme::create('ApiKey')
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
        return SecurityScheme::create('Bearer')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
