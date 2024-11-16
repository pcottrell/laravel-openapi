<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;

interface SchemaFactory extends ComponentFactory
{
    public function build(): Descriptor;
}
