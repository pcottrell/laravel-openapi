<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;

abstract class RequestBodyFactory
{
    use Referencable;

    abstract public function build(): RequestBody;
}
