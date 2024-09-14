<?php

namespace Tests\Unit\Collectors;

use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use MohammadAlavi\LaravelOpenApi\Collectors\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use PHPUnit\Framework\Attributes\CoversClass;
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
        $extensionBuilder = resolve(ExtensionBuilder::class);
        $extensionBuilder->build($operation, collect([
            new Extension(factory: \Tests\Stubs\FakeExtension::class),
        ]));

        $this->assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [
                        'x-uuid' => ['format' => 'uuid', 'type' => 'string'],
                    ],
                ],
            ],
        ], $openApi->toArray());
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
        $extensionBuilder = resolve(ExtensionBuilder::class);
        $extensionBuilder->build($operation, collect([
            new Extension(key: 'foo', value: 'bar'),
            new Extension(key: 'x-key', value: '1'),
        ]));

        $this->assertSame([
            'paths' => [
                '/foo' => [
                    'get' => [
                        'x-foo' => 'bar',
                        'x-key' => '1',
                    ],
                ],
            ],
        ], $openApi->toArray());
    }
}
