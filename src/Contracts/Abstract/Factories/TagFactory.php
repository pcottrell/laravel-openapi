<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

abstract class TagFactory
{
    abstract public function build(): Tag;
}
