<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ServerFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ServerVariable;

class ServerWithMultipleVariableFormatting extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description')
            ->variables(
                ServerVariable::create('ServerVariableA')
                    ->default('variable_defalut')
                    ->description('variable_description')
                    ->enum('A', 'B'),
                ServerVariable::create('ServerVariableB')
                    ->default('sample')
                    ->description('sample'),
            );
    }
}
