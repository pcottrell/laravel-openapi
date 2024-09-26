<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\ServerVariable;

class ServerWithVariables extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description')
            ->variables(
                ServerVariable::create('variable_name')
                    ->default('variable_defalut')
                    ->description('variable_description'),
            );
    }
}
