<?php

namespace Tests\Doubles\Stubs\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableCallbackFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

class ReusableComponentCallbackFactory extends ReusableCallbackFactory
{
    public function build(): PathItem
    {
        return PathItem::create();
    }
}
