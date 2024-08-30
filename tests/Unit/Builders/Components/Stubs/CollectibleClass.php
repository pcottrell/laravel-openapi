<?php

namespace Tests\Unit\Builders\Components\Stubs;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;

#[Collection('TestCollection')]
class CollectibleClass {
    // TODO: use this to test collectors
    //  also add another collection without the attribute so we can test the "default" collection
    //  also add method collection! cus controllers can in collection as well as specific actions (methods) on
    //   controllers can be in different collections
}