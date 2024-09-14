<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

class CallbackFactory extends AbstractFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
