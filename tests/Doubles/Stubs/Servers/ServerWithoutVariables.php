<?php

namespace Tests\Doubles\Stubs\Servers;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ServerFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;

class ServerWithoutVariables extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url('https://example.com')
            ->description('sample_description');
    }
}
