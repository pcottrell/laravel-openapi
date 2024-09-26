<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory as AbstractFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

class CallbackFactory extends AbstractFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
