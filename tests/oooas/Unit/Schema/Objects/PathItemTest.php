<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;

describe(class_basename(PathItem::class), function (): void {
    it('can be created with all parameters', function (): void {
        $paths = Paths::create(Path::create(
            '/users',
            PathItem::create()
                ->summary('User endpoints')
                ->description('Get the users')
                ->operations(Operation::get())
                ->servers(Server::create()->url('https://example.com'))
                ->parameters(
                    Parameter::create()->name('Test parameter'),
                ),
        ));

        expect($paths->asArray())->toBe([
            '/users' => [
                'summary' => 'User endpoints',
                'description' => 'Get the users',
                'get' => [],
                'servers' => [
                    ['url' => 'https://example.com'],
                ],
                'parameters' => [
                    ['name' => 'Test parameter'],
                ],
            ],
        ]);
    });
})->covers(PathItem::class);
