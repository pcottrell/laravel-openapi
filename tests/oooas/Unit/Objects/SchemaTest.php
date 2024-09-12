<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Discriminator;
use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\OneOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Objects\Xml;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Schema::class)]
class SchemaTest extends UnitTestCase
{
    public function testCreateArrayWithAllParametersWorks(): void
    {
        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->enum(['Earth'], ['Venus'], ['Mars'])
            ->default(['Earth'])
            ->type(Schema::TYPE_ARRAY)
            ->items(Schema::string())
            ->maxItems(10)
            ->minItems(1)
            ->uniqueItems()
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'enum' => [
                    ['Earth'],
                    ['Venus'],
                    ['Mars'],
                ],
                'default' => ['Earth'],
                'type' => 'array',
                'items' => ['type' => 'string'],
                'maxItems' => 10,
                'minItems' => 1,
                'uniqueItems' => true,
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateBooleanWithAllParametersWorks(): void
    {
        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->default(false)
            ->type(Schema::TYPE_BOOLEAN)
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'default' => false,
                'type' => 'boolean',
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateIntegerWithAllParametersWorks(): void
    {
        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->default(false)
            ->format(Schema::FORMAT_INT32)
            ->type(Schema::TYPE_INTEGER)
            ->maximum(100)
            ->exclusiveMaximum(101)
            ->minimum(1)
            ->exclusiveMinimum(0)
            ->multipleOf(2)
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'default' => false,
                'format' => 'int32',
                'type' => 'integer',
                'maximum' => 100,
                'exclusiveMaximum' => 101,
                'minimum' => 1,
                'exclusiveMinimum' => 0,
                'multipleOf' => 2,
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateNumberWithAllParametersWorks(): void
    {
        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->default(false)
            ->type(Schema::TYPE_NUMBER)
            ->maximum(100)
            ->exclusiveMaximum(101)
            ->minimum(1)
            ->exclusiveMinimum(0)
            ->multipleOf(2)
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'default' => false,
                'type' => 'number',
                'maximum' => 100,
                'exclusiveMaximum' => 101,
                'minimum' => 1,
                'exclusiveMinimum' => 0,
                'multipleOf' => 2,
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateObjectWithAllParametersWorks(): void
    {
        $property = Schema::string('id')
            ->format(Schema::FORMAT_UUID);

        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->default(false)
            ->type(Schema::TYPE_OBJECT)
            ->required($property)
            ->properties($property)
            ->additionalProperties(Schema::integer('age'))
            ->maxProperties(10)
            ->minProperties(1)
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'default' => false,
                'type' => 'object',
                'required' => ['id'],
                'properties' => [
                    'id' => [
                        'type' => 'string',
                        'format' => 'uuid',
                    ],
                ],
                'additionalProperties' => [
                    'type' => 'integer',
                ],
                'maxProperties' => 10,
                'minProperties' => 1,
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateStringWithAllParametersWorks(): void
    {
        $schema = Schema::create()
            ->title('Schema title')
            ->description('Schema description')
            ->default(false)
            ->format(Schema::FORMAT_UUID)
            ->type(Schema::TYPE_STRING)
            ->pattern('/[a-zA-Z]+/')
            ->maxLength(10)
            ->minLength(1)
            ->nullable()
            ->discriminator(Discriminator::create()->propertyName('Property name'))
            ->readOnly()
            ->writeOnly()
            ->xml(Xml::create())
            ->externalDocs(ExternalDocs::create()->url('https://goldspecdigital.com'))
            ->example(['Venus'])
            ->deprecated();

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertEquals([
            'schema' => [
                'title' => 'Schema title',
                'description' => 'Schema description',
                'default' => false,
                'format' => 'uuid',
                'type' => 'string',
                'pattern' => '/[a-zA-Z]+/',
                'maxLength' => 10,
                'minLength' => 1,
                'nullable' => true,
                'discriminator' => ['propertyName' => 'Property name'],
                'readOnly' => true,
                'writeOnly' => true,
                'xml' => [],
                'externalDocs' => ['url' => 'https://goldspecdigital.com'],
                'example' => ['Venus'],
                'deprecated' => true,
            ],
        ], $mediaType->toArray());
    }

    public function testCreateArrayWithRefWorks(): void
    {
        $schema = Schema::array()
            ->items(
                Schema::ref('#/components/schemas/pet'),
            );

        $this->assertSame([
            'type' => 'array',
            'items' => [
                '$ref' => '#/components/schemas/pet',
            ],
        ], $schema->toArray());
    }

    public function testCreateObjectWithOneOfWorks(): void
    {
        $string = Schema::string();
        $number = Schema::number();

        $schema = Schema::create()
            ->type(Schema::TYPE_OBJECT)
            ->properties(
                OneOf::create('poly_type')->schemas($string, $number),
            );

        $mediaType = MediaType::create()
            ->schema($schema);

        $this->assertSame([
            'schema' => [
                'type' => 'object',
                'properties' => [
                    'poly_type' => [
                        'oneOf' => [
                            [
                                'type' => 'string',
                            ],
                            [
                                'type' => 'number',
                            ],
                        ],
                    ],
                ],
            ],
        ], $mediaType->toArray());
    }
}