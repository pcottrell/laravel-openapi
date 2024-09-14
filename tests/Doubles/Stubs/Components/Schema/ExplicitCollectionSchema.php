<?php

namespace Tests\Doubles\Stubs\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

#[Collection('test')]
class ExplicitCollectionSchema extends SchemaFactory implements Reusable
{
    public function build(): Schema
    {
        return Schema::object();
    }
}
