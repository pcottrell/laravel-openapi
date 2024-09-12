<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Extensions;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\UnitTestCase;

#[CoversClass(Extensions::class)]
class ExtensionsTest extends UnitTestCase
{
    public static function schemasDataProvider(): \Iterator
    {
        yield [Components::class];
        yield [Operation::class];
        yield [PathItem::class];
        yield [Response::class];
        yield [Schema::class];
    }

    #[DataProvider('schemasDataProvider')]
    public function testCreateWithExtensions(string $schema): void
    {
        $object = $schema::create()
            ->x('key', 'value')
            ->x('x-foo', 'bar')
            ->x('x-baz', null)
            ->x('x-array', Schema::array()->items(Schema::string()));

        $this->assertEquals([
            'x-key' => 'value',
            'x-foo' => 'bar',
            'x-baz' => null,
            'x-array' => Schema::array()->items(Schema::string()),
        ], $object->toArray());

        $this->assertSame(
            '{"x-key":"value","x-foo":"bar","x-baz":null,"x-array":{"type":"array","items":{"type":"string"}}}',
            $object->toJson(),
        );
    }

    public function testCanUnsetExtensions(): void
    {
        $object = Schema::create()
            ->x('key', 'value')
            ->x('x-foo', 'bar')
            ->x('x-baz', null);

        $object = $object->x('key');

        $this->assertEquals([
            'x-foo' => 'bar',
            'x-baz' => null,
        ], $object->toArray());

        $this->assertSame('{"x-foo":"bar","x-baz":null}', $object->toJson());
    }

    #[DataProvider('schemasDataProvider')]
    public function testGetSingleExtension(string $schema): void
    {
        $object = $schema::create()->x('foo', 'bar');

        $this->assertSame('bar', $object->{'x-foo'});
    }

    #[DataProvider('schemasDataProvider')]
    public function testGetSingleExtensionDoesNotExist(string $schema): void
    {
        $object = $schema::create()->x('foo', 'bar');

        $this->expectException(PropertyDoesNotExistException::class);
        $this->expectExceptionMessage('[x-key] is not a valid property');
        $this->assertSame('bar', $object->{'x-key'});
    }

    #[DataProvider('schemasDataProvider')]
    public function testGetAllExtensions(string $schema): void
    {
        $object = $schema::create();

        $this->assertSame([], $object->x);

        $object = $object
            ->x('key', 'value')
            ->x('foo', 'bar');

        $this->assertSame(['x-key' => 'value', 'x-foo' => 'bar'], $object->x);
    }
}