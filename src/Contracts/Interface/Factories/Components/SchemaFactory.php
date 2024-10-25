<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\JsonSchema;

interface SchemaFactory extends ComponentFactory
{
    public function build(): JsonSchema;
}
