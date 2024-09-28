<?php

namespace Tests\Unit\Collectors;

use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use MohammadAlavi\LaravelOpenApi\Collectors\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\oooas\Enums\OASVersion;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Doubles\Stubs\FakeExtension;
use Tests\TestCase;

#[CoversClass(ExtensionBuilder::class)]
class ExtensionBuilderTest extends TestCase
{
    public function testBuildUsingFactory(): void
    {
        $operation = Operation::create()->action('get');

        $openApi = OpenApi::create()
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation),
            );

        /** @var ExtensionBuilder $extensionBuilder */
        $extensionBuilder = app(ExtensionBuilder::class);
        $extensionBuilder->build($operation, collect([
            new Extension(factory: FakeExtension::class),
        ]));

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/foo' => [
                    'get' => [
                        'x-uuid' => ['format' => 'uuid', 'type' => 'string'],
                    ],
                ],
            ],
        ], $openApi->jsonSerialize());
    }

    public function testBuildUsingKeyValue(): void
    {
        $operation = Operation::create()->action('get');

        $openApi = OpenApi::create()
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation),
            );

        /** @var ExtensionBuilder $extensionBuilder */
        $extensionBuilder = app(ExtensionBuilder::class);
        $extensionBuilder->build($operation, collect([
            new Extension(key: 'x-foo', value: 'bar'),
            new Extension(key: 'x-key', value: '1'),
        ]));

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/foo' => [
                    'get' => [
                        'x-foo' => 'bar',
                        'x-key' => '1',
                    ],
                ],
            ],
        ], $openApi->jsonSerialize());
    }
}
