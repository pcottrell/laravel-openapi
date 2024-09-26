<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;

abstract class ServerFactory
{
    abstract public function build(): Server;
}
