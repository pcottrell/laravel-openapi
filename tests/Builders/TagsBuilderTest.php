<?php

declare(strict_types=1);

namespace Vyuldashev\LaravelOpenApi\Tests\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use Vyuldashev\LaravelOpenApi\Builders\TagBuilder;
use Vyuldashev\LaravelOpenApi\Tests\TestCase;

class TagsBuilderTest extends TestCase
{
    /**
     * @dataProvider tagProvider
     */
    public function testBuild(array $config, array $expected): void
    {
        $builder = new TagBuilder();
        $tags = $builder->build($config);
        $this->assertSameAssociativeArray($expected[0], $tags[0]->toArray());
    }

    public function tagProvider(): array
    {
        return [
            'If the external docs do not exist, it can output the correct json.' => [
                [WithoutExternalDoc::class],
                [
                    [
                        'name' => 'post',
                        'description' => 'Posts',
                    ],
                ],
            ],
            'If the external docs are present and is array, it can output the correct json.' => [
                [WithExternalArrayDoc::class],
                [
                    [
                        'name' => 'post',
                        'description' => 'Posts',
                        'externalDocs' => [
                            'description' => 'External API documentation',
                            'url' => 'https://example.com/external-docs',
                        ],
                    ],
                ],
            ],
            'If the external docs are present and is object, it can output the correct json.' => [
                [WithExternalObjectDoc::class],
                [
                    [
                        'name' => 'post',
                        'description' => 'Posts',
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

class WithExternalArrayDoc extends Tag
{
    public $name = 'post';
    public $description = 'Posts';
    public $externalDocs = [
        'description' => 'External API documentation',
        'url' => 'https://example.com/external-docs',
    ];
}

class WithExternalObjectDoc extends Tag
{
    public $name = 'post';
    public $description = 'Posts';

    public function __construct()
    {
        parent::__construct(null);
        $this->externalDocs = (new ExternalDocs())->url('https://example.com/external-docs')->description('External API documentation');
    }
}

class WithoutExternalDoc extends Tag
{
    public $name = 'post';
    public $description = 'Posts';
}
