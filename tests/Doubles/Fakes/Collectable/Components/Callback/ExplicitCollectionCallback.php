<?php

namespace Tests\Doubles\Fakes\Collectable\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

#[Collection('test')]
class ExplicitCollectionCallback extends CallbackFactory implements Reusable
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
