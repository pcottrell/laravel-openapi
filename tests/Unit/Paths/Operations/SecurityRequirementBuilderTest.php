<?php

namespace Tests\Unit\Paths\Operations;

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as AttributesOperation;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Doubles\Stubs\SecuritySchemes\ApiKeySecurityScheme;
use Tests\Doubles\Stubs\SecuritySchemes\BearerSecurityScheme;
use Tests\Doubles\Stubs\SecuritySchemes\JwtSecurityScheme;
use Tests\TestCase;

#[CoversClass(SecurityRequirementBuilder::class)]
class SecurityRequirementBuilderTest extends TestCase
{
    public static function operationSecuritySchemesDataProvider(): \Iterator
    {
        yield 'No global security - no path security' => [
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
                JwtSecurityScheme::class,
                ApiKeySecurityScheme::class,
                BearerSecurityScheme::class,
            ],
            [], // applied global security
            null, // use default global securities
        ];
        yield 'Use default global security - have single class string security' => [
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
                ApiKeySecurityScheme::class,
                JwtSecurityScheme::class,
            ],
            [
                ApiKeySecurityScheme::class,
            ],
            null,
        ];
        yield 'Use default global security - have multi-auth security' => [
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
                    //  I don't think it is removed automatically.
                    ApiKeySecurityScheme::class,
                ],
            ],
            null,
        ];
        yield 'Override global security - disable global security' => [
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
                ApiKeySecurityScheme::class,
            ],
            [
                ApiKeySecurityScheme::class,
            ],
            [],
        ];
        yield 'Override global security - with same security' => [
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
                JwtSecurityScheme::class, // available global securities (components)
            ],
            [
                JwtSecurityScheme::class, // applied global securities
            ],
            JwtSecurityScheme::class, // security overrides
        ];
        yield 'Override global security - single auth class string' => [
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
                JwtSecurityScheme::class,
                ApiKeySecurityScheme::class,
            ],
            [
                ApiKeySecurityScheme::class,
            ],
            JwtSecurityScheme::class,
        ];
        yield 'Override global security - single auth array' => [
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
                JwtSecurityScheme::class,
                ApiKeySecurityScheme::class,
            ],
            [
                JwtSecurityScheme::class,
            ],
            [
                ApiKeySecurityScheme::class,
            ],
        ];
        yield 'Override global security - multi-auth (and) - single auth global security' => [
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
        ];
        yield 'Override global security - multi-auth (and) - multi auth global security' => [
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
        ];
        yield 'Override global security - multi-auth (or) - single auth global security' => [
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
        ];
        yield 'Override global security - multi-auth (or) - multi auth global security' => [
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
        ];
        yield 'Override global security - multi-auth (and + or) - single auth global security' => [
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
        ];
        yield 'Override global security - multi-auth (and + or) - multi auth global security' => [
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

    public static function globalSecuritySchemesDataProvider(): \Iterator
    {
        // JWT authentication only
        yield [
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
                JwtSecurityScheme::class,
            ],
            [
                [
                    JwtSecurityScheme::class,
                ],
            ],
        ];
        // ApiKey authentication only
        yield [
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
                ApiKeySecurityScheme::class,
            ],
            [
                ApiKeySecurityScheme::class,
            ],
        ];
        // Both JWT and ApiKey authentication required
        yield [
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
                JwtSecurityScheme::class,
                ApiKeySecurityScheme::class,
            ],
            [
                [
                    JwtSecurityScheme::class,
                    ApiKeySecurityScheme::class,
                ],
            ],
        ];
        // Either JWT or ApiKey authentication required
        yield [
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
        ];
        // And & Or combination
        yield [
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
        $routeInformation = RouteInformation::createFromRoute(Route::$action($route, static fn () => 'example'));
        $routeInformation->actionAttributes = collect([
            new AttributesOperation(security: $pathSecurity),
        ]);
        $operation = app(OperationBuilder::class)->build([$routeInformation])[0];
        $openApi = OpenApi::create();

        $openApi = $openApi
            ->components($components)
            ->multiAuthSecurity($globalSecurity)
            ->paths(
                PathItem::create()
                    ->route($route)
                    ->operations($operation),
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
            'paths' => [
                $route => $actionData,
            ], ...$collectionData,
        ], $openApi->toArray());
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
            ->multiAuthSecurity($globalSecurity)
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation),
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
        $this->assertSame($expected, $openApi->toArray());
        $this->assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
    }

    /**
     * We're just making sure we're getting the expected output.
     */
    public function testCanBuildUpTheSecurityScheme(): void
    {
        $jwtSecurityScheme = app(JwtSecurityScheme::class);
        $securityScheme = $jwtSecurityScheme->build();

        $components = Components::create()
            ->securitySchemes($securityScheme);

        $operation = Operation::create()
            ->action('get');

        $openApi = OpenApi::create()
            ->multiAuthSecurity([JwtSecurityScheme::class])
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation),
            );

        $expected = [
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
        $this->assertSame($expected, $openApi->toArray());
        $this->assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
    }

    /**
     * We're just verifying that the builder is capable of
     * adding security information to the operation.
     */
    public function testWeCanAddOperationSecurityUsingBuilder(): void
    {
        $jwtSecurityScheme = app(JwtSecurityScheme::class);
        $securityScheme = $jwtSecurityScheme->build();

        $components = Components::create()
            ->securitySchemes($securityScheme);

        $routeInformation = new RouteInformation();
        $routeInformation->action = 'get';
        $routeInformation->name = 'test route';
        $routeInformation->actionAttributes = collect([
            new AttributesOperation(security: JwtSecurityScheme::class),
        ]);
        $routeInformation->uri = '/example';

        /** @var SecurityRequirementBuilder $builder */
        $securityRequirementBuilder = app(SecurityRequirementBuilder::class);

        $operation = Operation::create()
            ->security($securityRequirementBuilder->build($routeInformation->actionAttributes[0]->security))
            ->action('get');

        $openApi = OpenApi::create()
            ->components($components)
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation),
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
                    'JWT' => self::jwtSecuritySchemeProvider(),
                ],
            ],
        ];
        $this->assertSame($expected, $openApi->toArray());
        $this->assertSame(json_encode($expected, JSON_THROW_ON_ERROR), $openApi->toJson());
    }
}
