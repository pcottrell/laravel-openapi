<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;

interface RequestBodyFactory extends ComponentFactory
{
    public function build(): RequestBody;
}
