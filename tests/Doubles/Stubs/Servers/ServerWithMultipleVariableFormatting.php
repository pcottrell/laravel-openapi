<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\ObjectOrientedOAS\Objects\ServerVariable;

class ServerWithMultipleVariableFormatting extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description')
            ->variables(
                ServerVariable::create('variable_name')
                    ->default('variable_defalut')
                    ->description('variable_description')
                    ->enum('A', 'B'),
                ServerVariable::create('variable_name_B')
                    ->default('sample')
                    ->description('sample'),
            );
    }
}
