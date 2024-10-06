<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SchemaContract;

interface SchemaFactory extends ComponentFactory
{
    public function build(): SchemaContract;
}
