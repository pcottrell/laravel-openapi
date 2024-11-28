<?php

namespace MohammadAlavi\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use MohammadAlavi\LaravelOpenApi\Builders\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\Tests\TestCase;

class ExtensionBuilderTest extends TestCase
{
    public function testBuildUsingFactory(): void
    {
        $operation = Operation::create()->action('get');

        $openApi = OpenApi::create()
            ->paths(
                PathItem::create()
                    ->route('/foo')
                    ->operations($operation)
            );

        /** @var ExtensionBuilder $builder */
        $builder = resolve(ExtensionBuilder::class);
        $builder->build($operation, collect([
            new Extension(factory: FakeExtension::class),
        ]));

        self::assertSame([
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
                    ->operations($operation)
            );

        /** @var ExtensionBuilder $builder */
        $builder = resolve(ExtensionBuilder::class);
        $builder->build($operation, collect([
            new Extension(key: 'foo', value: 'bar'),
            new Extension(key: 'x-key', value: '1'),
        ]));

        self::assertSame([
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

class FakeExtension extends ExtensionFactory
{
    public function key(): string
    {
        return 'uuid';
    }

    /**
     * @return string|array|null
     */
    public function value()
    {
        return Schema::string()->format(Schema::FORMAT_UUID);
    }
}