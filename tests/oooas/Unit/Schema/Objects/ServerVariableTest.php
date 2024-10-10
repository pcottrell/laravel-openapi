<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ServerVariable;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(ServerVariable::class)]
class ServerVariableTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $serverVariable = ServerVariable::create('ServerVariableName')
            ->enum('Earth', 'Mars', 'Saturn')
            ->default('Earth')
            ->description('The planet the server is running on');

        $server = Server::create()
            ->variables($serverVariable);

        $this->assertSame([
            'variables' => [
                'ServerVariableName' => [
                    'enum' => ['Earth', 'Mars', 'Saturn'],
                    'default' => 'Earth',
                    'description' => 'The planet the server is running on',
                ],
            ],
        ], $server->jsonSerialize());
    }
}
