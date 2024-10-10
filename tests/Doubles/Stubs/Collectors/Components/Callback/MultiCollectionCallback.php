<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableCallbackFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

#[Collection(['test', Generator::COLLECTION_DEFAULT])]
class MultiCollectionCallback extends ReusableCallbackFactory
{
    public function build(): PathItem
    {
        return PathItem::create()->path('/multi-collection-callback');
    }
}
