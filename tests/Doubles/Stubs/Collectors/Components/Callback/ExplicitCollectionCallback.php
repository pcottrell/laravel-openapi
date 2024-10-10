<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableCallbackFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

#[Collection('test')]
class ExplicitCollectionCallback extends ReusableCallbackFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
