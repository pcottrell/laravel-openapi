<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

interface CallbackFactory extends ComponentFactory
{
    public function build(): PathItem;
}
