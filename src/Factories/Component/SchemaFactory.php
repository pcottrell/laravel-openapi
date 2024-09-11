<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;

abstract class SchemaFactory
{
    use Referencable;

    abstract public function build(): SchemaContract;
}
