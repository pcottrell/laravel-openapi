<?php

namespace Tests\Unit\Collectors\Paths\Operations;

use Illuminate\Support\Facades\Route;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as AttributesOperation;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Doubles\Stubs\SecuritySchemesFactories\ApiKeySecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemesFactories\BearerSecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemesFactories\JwtSecuritySchemeFactory;
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
                JwtSecuritySchemeFactory::class,
                ApiKeySecuritySchemeFactory::class,
                BearerSecuritySchemeFactory::class,
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
                ApiKeySecuritySchemeFactory::class,
                JwtSecuritySchemeFactory::class,
            ],
            [
                ApiKeySecuritySchemeFactory::class,
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
                ApiKeySecuritySchemeFactory::class,
            ],
            [
                ApiKeySecuritySchemeFactory::class,
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
                JwtSecuritySchemeFactory::class, // available global securities (components)
            ],
            [
                JwtSecuritySchemeFactory::class, // applied global securities
            ],
            JwtSecuritySchemeFactory::class, // security overrides
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
                JwtSecuritySchemeFactory::class,
                ApiKeySecuritySchemeFactory::class,
            ],
            [
                ApiKeySecuritySchemeFactory::class,
            ],
            JwtSecuritySchemeFactory::class,
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
                JwtSecuritySchemeFactory::class,
                ApiKeySecuritySchemeFactory::class,
            ],
            [
                JwtSecuritySchemeFactory::class,
            ],
            [
                ApiKeySecuritySchemeFactory::class,
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
                JwtSecuritySchemeFactory::class,
            ],
            [
                [
                    JwtSecuritySchemeFactory::class,
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
                ApiKeySecuritySchemeFactory::class,
            ],
            [
                ApiKeySecuritySchemeFactory::class,
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
                JwtSecuritySchemeFactory::class,
                ApiKeySecuritySchemeFactory::class,
            ],
            [
                [
                    JwtSecuritySchemeFactory::class,
                    ApiKeySecuritySchemeFactory::class,
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
        $routeInformation = RouteInformation::createFromRoute(Route::$action($route, static fn (): string => 'example'));
        $routeInformation->actionAttributes = collect([
            new AttributesOperation(security: $pathSecurity),
        ]);
        $operation = app(OperationBuilder::class)->build([$routeInformation])[0];
        $openApi = OpenApi::create();

        $openApi = $openApi
            ->components($components)
            ->nestedSecurity($globalSecurity)
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
        $routeInformation->uri = '/example';

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
        $this->assertSame($expected, $openApi->jsonSerialize());
    }
}
