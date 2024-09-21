<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

#[Collection(['test', Generator::COLLECTION_DEFAULT])]
class MultiCollectionCallback extends CallbackFactory implements Reusable
{
    public function build(): PathItem
    {
        return PathItem::create('test collection PathItem');
    }
}
