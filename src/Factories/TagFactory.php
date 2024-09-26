<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

abstract class TagFactory
{
    abstract public function build(): Tag;
}
