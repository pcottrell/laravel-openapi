<?php

namespace Tests\Unit\Attributes\Stubs;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;

class CallbackFactoryStub extends CallbackFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}