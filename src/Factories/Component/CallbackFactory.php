<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

abstract class CallbackFactory
{
    use Referencable;

    abstract public function build(): PathItem;
}
