<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;

abstract class CallbackFactory
{
    abstract public function build(): PathItem;
}
