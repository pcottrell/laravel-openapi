<?php

namespace Tests\Unit\Collectors\Paths\Operations;

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as AttributesOperation;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\SecurityBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Doubles\Stubs\SecuritySchemesFactories\ApiKeySecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemesFactories\BearerSecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemesFactories\JwtSecuritySchemeFactory;
use Tests\TestCase;

#[CoversClass(SecurityBuilder::class)]
class SecurityBuilderTest extends TestCase
{
    public static function operationSecuritySchemesDataProvider(): array
    {
        return ['No global security - no path security' => [
            [
                'components' => [
                    'securitySchemes' => [
                        'JWT' => self::jwtSecuritySchemeProvider(),
                        'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                        'Bearer' => self::bearerAuthSecuritySchemeProvider(),
                    ],
                ],
                'globalSecurity' => null,
                'pathSecurity' => null,
            ],
            [ // available global securities (components)
                JwtSecuritySchemeFactory::class,
                ApiKeySecuritySchemeFactory::class,
                BearerSecuritySchemeFactory::class,
            ],
            [], // applied global security
            null, // use default global securities
        ],
            'Use default global security - have single class string security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'JWT' => self::jwtSecuritySchemeProvider(),
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
                    ApiKeySecuritySchemeFactory::class,
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
                null,
            ],
            'Use default global security - have multi-auth security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
                            'JWT' => self::jwtSecuritySchemeProvider(),
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
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                    [
                        ApiKeySecuritySchemeFactory::class,
                        JwtSecuritySchemeFactory::class,
                    ],
                    BearerSecuritySchemeFactory::class,
                    [
                        BearerSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                    ],
                    [
                        BearerSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                        JwtSecuritySchemeFactory::class,
                    ],
                    [
                        // TODO: should this duplication be removed?
                        //  I don't think it is removed automatically.
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
                null,
            ],
            'Override global security - disable global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
                [],
            ],
            'Override global security - with same security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class, // available global securities (components)
                ],
                [
                    JwtSecuritySchemeFactory::class, // applied global securities
                ],
                JwtSecuritySchemeFactory::class, // security overrides
            ],
            'Override global security - single auth class string' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
                JwtSecuritySchemeFactory::class,
            ],
            'Override global security - single auth array' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
            ],
            'Override global security - multi-auth (and) - single auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    [
                        ApiKeySecuritySchemeFactory::class,
                        BearerSecuritySchemeFactory::class,
                    ],
                ],
            ],
            'Override global security - multi-auth (and) - multi auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    [
                        BearerSecuritySchemeFactory::class,
                        JwtSecuritySchemeFactory::class,
                    ],
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
            'Override global security - multi-auth (or) - single auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                    ],
                    [
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
            'Override global security - multi-auth (or) - multi auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    [
                        BearerSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                    ],
                    [
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
            'Override global security - multi-auth (and + or) - single auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    BearerSecuritySchemeFactory::class,
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                    [
                        JwtSecuritySchemeFactory::class,
                        BearerSecuritySchemeFactory::class,
                    ],
                ],
            ],
            'Override global security - multi-auth (and + or) - multi auth global security' => [
                [
                    'components' => [
                        'securitySchemes' => [
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    BearerSecuritySchemeFactory::class,
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    [
                        BearerSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
                [
                    [
                        BearerSecuritySchemeFactory::class,
                    ],
                    [
                        JwtSecuritySchemeFactory::class,
                        BearerSecuritySchemeFactory::class,
                    ],
                    [
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
        ];
    }

    /** @return string[] */
    private static function jwtSecuritySchemeProvider(): array
    {
        return [
            'type' => 'http',
            'name' => 'JwtTestScheme',
            'in' => 'header',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT',
        ];
    }

    /** @return string[] */
    private static function apiKeyAuthSecuritySchemeProvider(): array
    {
        return [
            'type' => 'apiKey',
            'name' => 'X-API-KEY',
            'in' => 'header',
            'scheme' => 'apiKey',
        ];
    }

    /** @return string[] */
    private static function bearerAuthSecuritySchemeProvider(): array
    {
        return [
            'type' => 'http',
            'scheme' => 'bearer',
        ];
    }

    public static function globalSecuritySchemesDataProvider(): array
    {
        return [
            // JWT authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'JWT' => [],
                        ],
                    ],
                ],
                [
                    JwtSecuritySchemeFactory::class,
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                    ],
                ],
            ],
            // ApiKey authentication only
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                        ],
                    ],
                    'security' => [
                        [
                            'ApiKey' => [],
                        ],
                    ],
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    ApiKeySecuritySchemeFactory::class,
                ],
            ],
            // Both JWT and ApiKey authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
            // Either JWT or ApiKey authentication required
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                ],
                [
                    [
                        JwtSecuritySchemeFactory::class,
                    ],
                    [
                        ApiKeySecuritySchemeFactory::class,
                    ],
                ],
            ],
            // And & Or combination
            [
                [
                    'components' => [
                        'securitySchemes' => [
                            'JWT' => self::jwtSecuritySchemeProvider(),
                            'ApiKey' => self::apiKeyAuthSecuritySchemeProvider(),
                            'Bearer' => self::bearerAuthSecuritySchemeProvider(),
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
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
                    BearerSecuritySchemeFactory::class,
                ],
                [
                    BearerSecuritySchemeFactory::class,
                    [
                        JwtSecuritySchemeFactory::class,
                        BearerSecuritySchemeFactory::class,
                    ],
                    [
                        BearerSecuritySchemeFactory::class,
                    ],
                    JwtSecuritySchemeFactory::class,
                    [
                        ApiKeySecuritySchemeFactory::class,
                    ],
                    ApiKeySecuritySchemeFactory::class,
                ],
            ],
        ];
    }

    #[DataProvider('operationSecuritySchemesDataProvider')]
    public function testCanApplyMultipleSecuritySchemesOnOperation(
        array $expectedJson,
        array $securitySchemeFactories,
        array $globalSecurity,
        string|array|null $pathSecurity,
    ): void {
        $components = Components::create()->securitySchemes(
            ...collect($securitySchemeFactories)->map(
                static fn (string $securitySchemeFactory): SecurityScheme => app($securitySchemeFactory)->build(),
            )->toArray(),
        );

        $route = '/foo';
        $action = 'get';
        $routeInformation = RouteInformation::createFromRoute(
            Route::$action($route, static fn (): string => 'example'),
        );
        $routeInformation->actionAttributes = collect([
            new AttributesOperation(security: $pathSecurity),
        ]);
        $operation = app(OperationBuilder::class)->build($routeInformation);

        $openApi = OpenApi::create()
            ->components($components)
            ->nestedSecurity($globalSecurity)
            ->paths(
                Paths::create(
                    Path::create(
                        $route,
                        PathItem::create()
                            ->operations($operation),
                    ),
                ),
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

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                $route => $actionData,
            ], ...$collectionData,
        ], $openApi->jsonSerialize());
    }

    #[DataProvider('globalSecuritySchemesDataProvider')]
    public function testCanApplyMultipleSecuritySchemesGlobally(
        array $expectedJson,
        array $securitySchemeComponents,
        array $globalSecurity,
    ): void {
        $components = Components::create()->securitySchemes(
            ...collect($securitySchemeComponents)->map(
                static fn (string $securitySchemeFactory): SecurityScheme => app($securitySchemeFactory)->build(),
            )->toArray(),
        );

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->nestedSecurity($globalSecurity)
            ->components($components)
            ->paths(
                Paths::create(
                    Path::create(
                        '/foo',
                        PathItem::create()
                            ->operations($operation),
                    ),
                ),
            );

        // Assert that the generated JSON matches the expected JSON for this scenario
        $expected = [
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/foo' => [
                    'get' => [
                    ],
                ],
            ],
            'components' => $expectedJson['components'],
            'security' => $expectedJson['security'],
        ];
        $this->assertSame($expected, $openApi->jsonSerialize());
    }

    /**
     * We're just making sure we're getting the expected output.
     */
    public function testCanBuildUpTheSecurityScheme(): void
    {
        $jwtSecuritySchemeFactory = app(JwtSecuritySchemeFactory::class);
        $securityScheme = $jwtSecuritySchemeFactory->build();

        $components = Components::create()
            ->securitySchemes($securityScheme);

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->nestedSecurity([JwtSecuritySchemeFactory::class])
            ->components($components)
            ->paths(
                Paths::create(
                    Path::create(
                        '/foo',
                        PathItem::create()
                            ->operations($operation),
                    ),
                ),
            );

        $expected = [
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/foo' => [
                    'get' => [],
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'JWT' => self::jwtSecuritySchemeProvider(),
                ],
            ],
            'security' => [
                [
                    'JWT' => [],
                ],
            ],
        ];
        $this->assertSame($expected, $openApi->jsonSerialize());
    }

    /**
     * We're just verifying that the builder is capable of
     * adding security information to the operation.
     */
    public function testWeCanAddOperationSecurityUsingBuilder(): void
    {
        $jwtSecuritySchemeFactory = app(JwtSecuritySchemeFactory::class);
        $securityScheme = $jwtSecuritySchemeFactory->build();

        $components = Components::create()
            ->securitySchemes($securityScheme);

        $routeInformation = new RouteInformation();
        $routeInformation->action = 'get';
        $routeInformation->name = 'test route';
        $routeInformation->actionAttributes = collect([
            new AttributesOperation(security: JwtSecuritySchemeFactory::class),
        ]);
        $routeInformation->url = '/example';

        $securityBuilder = app(SecurityBuilder::class);

        $operation = Operation::create()
            ->security($securityBuilder->build($routeInformation->actionAttributes[0]->security))
            ->action('get');

        $openApi = OpenApi::create()
            ->components($components)
            ->paths(
                Paths::create(
                    Path::create(
                        '/foo',
                        PathItem::create()
                            ->operations($operation),
                    ),
                ),
            );

        $expected = [
            'openapi' => OASVersion::V_3_1_0->value,
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
                    'JWT' => self::jwtSecuritySchemeProvider(),
                ],
            ],
        ];
        $this->assertSame($expected, $openApi->jsonSerialize());
    }
}
