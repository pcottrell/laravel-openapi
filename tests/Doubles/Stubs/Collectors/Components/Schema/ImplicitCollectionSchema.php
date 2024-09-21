<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ImplicitCollectionSchema extends SchemaFactory implements Reusable
{
    public function build(): Schema
    {
        return Schema::object('default collection Schema')
            ->properties(Schema::integer('id'));
    }
}
