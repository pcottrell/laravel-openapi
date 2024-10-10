<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ServerFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ServerVariable;

class ServerWithEnum extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description')
            ->variables(
                ServerVariable::create()
                    ->default('variable_defalut')
                    ->description('variable_description')
                    ->enum('A', 'B', 'C'),
            );
    }
}
