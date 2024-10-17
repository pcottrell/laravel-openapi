<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(PathItem::class)]
class PathItemTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $path = Path::create(
            '/users',
            PathItem::create()
                ->summary('User endpoints')
                ->description('Get the users')
                ->operations(Operation::get())
                ->servers(Server::create()->url('https://example.com'))
                ->parameters(
                    Parameter::create()->name('Test parameter'),
                ),
        );

        $openApi = OpenApi::create()
            ->paths(Paths::create($path));

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/users' => [
                    'get' => [],
                    'summary' => 'User endpoints',
                    'description' => 'Get the users',
                    'servers' => [
                        ['url' => 'https://example.com'],
                    ],
                    'parameters' => [
                        ['name' => 'Test parameter'],
                    ],
                ],
            ],
        ], $openApi->jsonSerialize());
    }
}