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
use Tests\UnitTestCase;

#[CoversClass(Extensions::class)]
class ExtensionsTest extends UnitTestCase
{
    public static function schemasDataProvider(): array
    {
        return [
            [Components::class],
            [Operation::class],
            [PathItem::class],
            [Response::class],
            [Schema::class],
        ];
    }

    /**
     * @dataProvider schemasDataProvider
     *
     * @param string|Schema $schema
     */
    public function testCreateWithExtensions($schema)
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

        $this->assertEquals(
            '{"x-key":"value","x-foo":"bar","x-baz":null,"x-array":{"type":"array","items":{"type":"string"}}}',
            $object->toJson(),
        );
    }

    public function testCanUnsetExtensions()
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

        $this->assertEquals('{"x-foo":"bar","x-baz":null}', $object->toJson());
    }

    /**
     * @dataProvider schemasDataProvider
     *
     * @param string|Schema $schema
     */
    public function testGetSingleExtension($schema)
    {
        $object = $schema::create()->x('foo', 'bar');

        $this->assertEquals('bar', $object->{'x-foo'});
    }

    /**
     * @dataProvider schemasDataProvider
     *
     * @param string|Schema $schema
     */
    public function testGetSingleExtensionDoesNotExist($schema)
    {
        $object = $schema::create()->x('foo', 'bar');

        $this->expectException(PropertyDoesNotExistException::class);
        $this->expectExceptionMessage('[x-key] is not a valid property');
        $this->assertEquals('bar', $object->{'x-key'});
    }

    /**
     * @dataProvider schemasDataProvider
     *
     * @param string|Schema $schema
     */
    public function testGetAllExtensions($schema)
    {
        $object = $schema::create();

        $this->assertEquals([], $object->x);

        $object = $object
            ->x('key', 'value')
            ->x('foo', 'bar');

        $this->assertEquals(['x-key' => 'value', 'x-foo' => 'bar'], $object->x);
    }
}
