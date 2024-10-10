<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ServerVariable;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Server::class)]
class ServerTestTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $serverVariable = ServerVariable::create('ServerVariableName')
            ->default('Default value');

        $server = Server::create()
            ->url('https://api.example.con/v1')
            ->description('Core API')
            ->variables($serverVariable);

        $this->assertSame([
            'url' => 'https://api.example.con/v1',
            'description' => 'Core API',
            'variables' => [
                'ServerVariableName' => [
                    'default' => 'Default value',
                ],
            ],
        ], $server->jsonSerialize());
    }

    public function testVariablesAreSupported(): void
    {
        $serverVariable = ServerVariable::create('username')
            ->default('demo');

        $server = Server::create()
            ->url('https://api.example.con/v1')
            ->variables($serverVariable);

        $this->assertSame(
            [
                'url' => 'https://api.example.con/v1',
                'variables' => [
                    'username' => [
                        'default' => 'demo',
                    ],
                ],
            ],
            $server->jsonSerialize(),
        );
    }
}
