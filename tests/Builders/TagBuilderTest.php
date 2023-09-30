<?php

declare(strict_types=1);

namespace Vyuldashev\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Builders\TagBuilder;
use Vyuldashev\LaravelOpenApi\Factories\TagFactory;
use Vyuldashev\LaravelOpenApi\Tests\TestCase;

class TagBuilderTest extends TestCase
{
    /**
     * @dataProvider tagProvider
     */
    public function testCanBuildTag(array|string $tagFactories, array $expected): void
    {
        $tagBuilder = app(TagBuilder::class);
        $tags = $tagBuilder->build($tagFactories);
        $this->assertSameAssociativeArray($expected[0], $tags[0]->toArray());
    }

    public function tagProvider(): array
    {
        return [
            'can build factory from FQCN' => [
                [WithoutExternalDoc::class],
                [
                    [
                        'name' => 'Post',
                        'description' => 'Post Tag',
                    ],
                ],
            ],
            'If the external docs do not exist, it can output the correct json.' => [
                [WithoutExternalDoc::class],
                [
                    [
                        'name' => 'Post',
                        'description' => 'Post Tag',
                    ],
                ],
            ],
            'If the external docs are present and is object, it can output the correct json.' => [
                [WithExternalObjectDoc::class],
                [
                    [
                        'name' => 'Post',
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
        self::assertCount(0, $actual, sprintf('[%s] does not matched keys.', join(', ', array_keys($actual))));
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
            ->name('Post')
            ->description('Post Tag');
    }
}

class WithExternalObjectDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('Post')
            ->description('Post Tag')
            ->externalDocs(
                ExternalDocs::create()
                    ->description('External API documentation')
                    ->url('https://example.com/external-docs')
            );
    }
}
