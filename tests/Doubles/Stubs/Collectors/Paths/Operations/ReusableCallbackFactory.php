<?php

namespace Tests\Doubles\Stubs\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

class ReusableCallbackFactory extends CallbackFactory implements Reusable
{
    public function build(): PathItem
    {
        return PathItem::create('test');
    }
}
