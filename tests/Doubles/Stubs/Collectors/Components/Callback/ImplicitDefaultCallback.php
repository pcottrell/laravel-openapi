<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Callback;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

class ImplicitDefaultCallback extends CallbackFactory implements Reusable
{
    public function build(): PathItem
    {
        return PathItem::create('default collection PathItem');
    }
}
