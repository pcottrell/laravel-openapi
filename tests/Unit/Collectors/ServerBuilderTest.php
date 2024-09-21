<?php

namespace Tests\Unit\Collectors;

use MohammadAlavi\LaravelOpenApi\Collectors\ServerBuilder;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Doubles\Stubs\Servers\ServerWithEnum;
use Tests\Doubles\Stubs\Servers\ServerWithMultipleVariableFormatting;
use Tests\Doubles\Stubs\Servers\ServerWithoutVariables;
use Tests\Doubles\Stubs\Servers\ServerWithVariables;
use Tests\TestCase;

#[CoversClass(ServerBuilder::class)]
class ServerBuilderTest extends TestCase
{
    public static function serverFQCNProvider(): array
    {
        return ['Can build server without variables' => [
            [ServerWithoutVariables::class],
            [
                [
                    'url' => 'https://example.com',
                    'description' => 'sample_description',
                ],
            ],
        ],
            'Can build server with variables' => [
                [ServerWithVariables::class],
                [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                        ],
                    ],
                ],
            ],
            'Can build server containing enum' => [
                [ServerWithEnum::class],
                [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                                'enum' => [
                                    'A',
                                    'B',
                                    'C',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'Can build server containing variables fields in multiple formats' => [
                [ServerWithMultipleVariableFormatting::class],
                [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                                'enum' => ['A', 'B'],
                            ],
                            'variable_name_B' => [
                                'default' => 'sample',
                                'description' => 'sample',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function multiTagProvider(): array
    {
        return [
            'Can build multiple server from an array of FQCNs' => [
                [ServerWithVariables::class, ServerWithMultipleVariableFormatting::class],
                [
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                        ],
                    ],
                    [
                        'url' => 'https://example.com',
                        'description' => 'sample_description',
                        'variables' => [
                            'variable_name' => [
                                'enum' => ['A', 'B'],
                                'default' => 'variable_defalut',
                                'description' => 'variable_description',
                            ],
                            'variable_name_B' => [
                                'default' => 'sample',
                                'description' => 'sample',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function invalidServerProvider(): array
    {
        return [
            'server with empty string url' => [
                fn () => new class () extends ServerWithVariables {
                    public function build(): Server
                    {
                        return Server::create()->url('')->description('sample_description');
                    }
                },
            ],
            'server with null url' => [
                fn () => new class () extends ServerWithVariables {
                    public function build(): Server
                    {
                        return Server::create()->url(null)->description('sample_description');
                    }
                },
            ],
        ];
    }

    #[DataProvider('serverFQCNProvider')]
    public function testCanBuildServerFromFQCN(array $factories, array $expected): void
    {
        $builder = new ServerBuilder();
        $servers = $builder->build($factories);
        $this->assertSameAssociativeArray($expected[0], $servers[0]->toArray());
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
    public function testCanBuildFromServerArray(array $factories, array $expected): void
    {
        $builder = app(ServerBuilder::class);
        $servers = $builder->build($factories);

        $this->assertSame($expected, collect($servers)->map(static fn (Server $server): array => $server->toArray())->toArray());
    }

    #[DataProvider('invalidServerProvider')]
    public function testGivenNameNotProvidedCanProduceCorrectException($factory): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $builder = app(ServerBuilder::class);
        $builder->build([$factory()::class]);
    }
}
