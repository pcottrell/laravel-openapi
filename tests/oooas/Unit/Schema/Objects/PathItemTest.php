<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(PathItem::class)]
class PathItemTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $pathItem = PathItem::create()
            ->route('/users')
            ->summary('User endpoints')
            ->description('Get the users')
            ->operations(Operation::get())
            ->servers(Server::create()->url('https://example.com'))
            ->parameters(Parameter::create()->name('Test parameter'));

        $openApi = OpenApi::create()
            ->paths($pathItem);

        $this->assertSame([
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
        ], $openApi->serialize());
    }
}
