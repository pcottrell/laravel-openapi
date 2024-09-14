<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;

class ServerWithoutVariables extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description');
    }
}
