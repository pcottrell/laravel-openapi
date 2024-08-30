<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;

abstract class ResponseFactory
{
    use Referencable;

    abstract public function build(): Response;
}
