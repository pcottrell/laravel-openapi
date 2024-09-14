<?php

namespace Tests\Unit\Collectors;

use MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(TagBuilder::class)]
class TagBuilderTest extends TestCase
{
    public static function singleTagProvider(): \Iterator
    {
        yield 'Can build tag from array with one FQCN' => [
            [\Tests\Stubs\Tags\WithoutExternalDoc::class],
            [
                [
                    'name' => 'PostWithoutExternalDoc',
                    'description' => 'Post Tag',
                ],
            ],
        ];
        yield 'Can build tag without external docs' => [
            [\Tests\Stubs\Tags\WithoutExternalDoc::class],
            [
                [
                    'name' => 'PostWithoutExternalDoc',
                    'description' => 'Post Tag',
                ],
            ],
        ];
        yield 'Can build tag with external docs' => [
            [\Tests\Stubs\Tags\WithExternalObjectDoc::class],
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
        ];
    }

    public static function multiTagProvider(): \Iterator
    {
        yield 'Can build multiple tags from an array of FQCNs' => [
            [\Tests\Stubs\Tags\WithoutExternalDoc::class, \Tests\Stubs\Tags\WithExternalObjectDoc::class],
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
        ];
    }

    public static function invalidTagProvider(): \Iterator
    {
        yield [\Tests\Stubs\Tags\WithoutName::class];
        yield [\Tests\Stubs\Tags\EmptyStringName::class];
        yield [\Tests\Stubs\Tags\NullName::class];
    }

    #[DataProvider('singleTagProvider')]
    public function testCanBuildTag(array $tagFactories, array $expected): void
    {
        $tagBuilder = app(TagBuilder::class);
        $tags = $tagBuilder->build($tagFactories);

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

            $this->assertSame($value, $actual[$key]);
            unset($actual[$key]);
        }

        $this->assertCount(0, $actual, sprintf('[%s] does not matched keys.', implode(', ', array_keys($actual))));
    }

    #[DataProvider('multiTagProvider')]
    public function testCanBuildFromTagArray(array $tagFactories, array $expected): void
    {
        $tagBuilder = app(TagBuilder::class);
        $tags = $tagBuilder->build($tagFactories);

        $this->assertSame($expected, collect($tags)->map(static fn (Tag $tag): array => $tag->toArray())->toArray());
    }

    #[DataProvider('invalidTagProvider')]
    public function testGivenNameNotProvidedCanProduceCorrectException(string $invalidTag): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name is required.');

        $tagBuilder = app(TagBuilder::class);
        $tagBuilder->build([$invalidTag]);
    }
}
