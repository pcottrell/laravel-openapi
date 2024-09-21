<?php

namespace Tests\Unit\Collectors;

use MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Doubles\Stubs\Tags\TagWithExternalObjectDoc;
use Tests\Doubles\Stubs\Tags\TagWithoutExternalDoc;
use Tests\TestCase;

#[CoversClass(TagBuilder::class)]
class TagBuilderTest extends TestCase
{
    public static function singleTagProvider(): array
    {
        return ['Can build tag from array with one FQCN' => [
            [TagWithoutExternalDoc::class],
            [
                [
                    'name' => 'PostWithoutExternalDoc',
                    'description' => 'Post Tag',
                ],
            ],
        ],
            'Can build tag without external docs' => [
                [TagWithoutExternalDoc::class],
                [
                    [
                        'name' => 'PostWithoutExternalDoc',
                        'description' => 'Post Tag',
                    ],
                ],
            ],
            'Can build tag with external docs' => [
                [TagWithExternalObjectDoc::class],
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

    public static function multiTagProvider(): array
    {
        return [
            'Can build multiple tags from an array of FQCNs' => [
                [TagWithoutExternalDoc::class, TagWithExternalObjectDoc::class],
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

    public static function invalidTagProvider(): array
    {
        return [
            'tag without name' => [
                fn () => new class () extends TagFactory {
                    public function build(): Tag
                    {
                        return Tag::create()->description('Post Tag');
                    }
                },
            ],
            'tag with empty string name' => [
                fn () => new class () extends TagFactory {
                    public function build(): Tag
                    {
                        return Tag::create()->name('')->description('Post Tag');
                    }
                },
            ],
            'tag with null name' => [
                fn () => new class () extends TagFactory {
                    public function build(): Tag
                    {
                        return Tag::create()->name(null)->description('Post Tag');
                    }
                },
            ],
        ];
    }

    #[DataProvider('singleTagProvider')]
    public function testCanBuildTag(array $factories, array $expected): void
    {
        $builder = app(TagBuilder::class);
        $tags = $builder->build($factories);

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
    public function testCanBuildFromTagArray(array $factories, array $expected): void
    {
        $builder = app(TagBuilder::class);
        $tags = $builder->build($factories);

        $this->assertSame($expected, collect($tags)->map(static fn (Tag $tag): array => $tag->toArray())->toArray());
    }

    #[DataProvider('invalidTagProvider')]
    public function testGivenNameNotProvidedCanProduceCorrectException($factory): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $builder = app(TagBuilder::class);
        $builder->build([$factory()::class]);
    }
}
