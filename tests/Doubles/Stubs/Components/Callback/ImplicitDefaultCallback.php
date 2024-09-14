<?php

namespace Tests\Doubles\Stubs\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

class ImplicitDefaultCallback extends CallbackFactory implements Reusable
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
