<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

#[Collection('test')]
class ExplicitCollectionSchema extends SchemaFactory implements Reusable
{
    public function build(): Schema
    {
        return Schema::object('test collection Schema')
            ->properties(Schema::integer('id'));
    }
}
