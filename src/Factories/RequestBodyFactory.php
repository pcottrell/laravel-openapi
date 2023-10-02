<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;

abstract class RequestBodyFactory
{
    use Referencable;

    abstract public function build(): RequestBody;
}
