<?php

namespace Tests\Unit\Attributes\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

class CallbackFactoryStub extends CallbackFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
