<?php

declare(strict_types=1);

namespace MohammadAlavi\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use InvalidArgumentException;
use MohammadAlavi\LaravelOpenApi\Builders\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\LaravelOpenApi\Tests\TestCase;

class TagBuilderTest extends TestCase
{
    /**
     * @dataProvider singleTagProvider
     */
    public function testCanBuildTag(array $tagFactories, array $expected): void
    {
        $builder = app(TagBuilder::class);
        $tags = $builder->build($tagFactories);

        $this->assertSameAssociativeArray($expected[0], $tags[0]->toArray());
    }

    /**
     * Assert equality as an associative array.
     */
    protected function assertSameAssociativeArray(array $expected, array $actual): void
    {
        foreach ($expected as $key => $value) {
            if (is_array($value)) {
                $this->assertSameAssociativeArray($value, $actual[$key]);
                unset($actual[$key]);
                continue;
            }
            self::assertSame($value, $actual[$key]);
            unset($actual[$key]);
        }
        self::assertCount(0, $actual, sprintf('[%s] does not matched keys.', implode(', ', array_keys($actual))));
    }

    public function singleTagProvider(): array
    {
        return [
            'Can build tag from array with one FQCN' => [
                [WithoutExternalDoc::class],
                [
                    [
                        'name' => 'PostWithoutExternalDoc',
                        'description' => 'Post Tag',
                    ],
                ],
            ],
            'Can build tag without external docs' => [
                [WithoutExternalDoc::class],
                [
                    [
                        'name' => 'PostWithoutExternalDoc',
                        'description' => 'Post Tag',
                    ],
                ],
            ],
            'Can build tag with external docs' => [
                [WithExternalObjectDoc::class],
                [
                    [
                        'name' => 'PostWithExternalObjectDoc',
                        'description' => 'Post Tag',
                        'externalDocs' => [
                            'description' => 'External API documentation',
                            'url' => 'https://example.com/external-docs',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function multiTagProvider()
    {
        return [
            'Can build multiple tags from an array of FQCNs' => [
                [WithoutExternalDoc::class, WithExternalObjectDoc::class],
                [
                    [
                        'name' => 'PostWithoutExternalDoc',
                        'description' => 'Post Tag',
                    ],
                    [
                        'name' => 'PostWithExternalObjectDoc',
                        'description' => 'Post Tag',
                        'externalDocs' => [
                            'description' => 'External API documentation',
                            'url' => 'https://example.com/external-docs',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider multiTagProvider
     */
    public function testCanBuildFromTagArray(array $tagFactories, array $expected): void
    {
        $builder = app(TagBuilder::class);
        $tags = $builder->build($tagFactories);

        $this->assertSame($expected, collect($tags)->map(static fn (Tag $tag): array => $tag->toArray())->toArray());
    }

    public function invalidTagProvider()
    {
        return [
            [WithoutName::class],
            [EmptyStringName::class],
            [NullName::class],
        ];
    }

    /**
     * @dataProvider invalidTagProvider
     */
    public function testGivenNameNotProvidedCanProduceCorrectException(string $invalidTag): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name is required.');

        $tagBuilder = app(TagBuilder::class);
        $tagBuilder->build([$invalidTag]);
    }
}

class WithoutName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->description('Post Tag');
    }
}

class EmptyStringName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('')
            ->description('Post Tag');
    }
}

class NullName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name(null)
            ->description('Post Tag');
    }
}

class WithoutExternalDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('PostWithoutExternalDoc')
            ->description('Post Tag');
    }
}

class WithExternalObjectDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('PostWithExternalObjectDoc')
            ->description('Post Tag')
            ->externalDocs(
                ExternalDocs::create()
                    ->description('External API documentation')
                    ->url('https://example.com/external-docs')
            );
    }
}