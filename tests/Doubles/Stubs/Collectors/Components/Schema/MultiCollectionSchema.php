<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

#[Collection(['test', Generator::COLLECTION_DEFAULT])]
class MultiCollectionSchema extends SchemaFactory implements Reusable
{
    public function build(): Schema
    {
        return Schema::object('test collection Schema')
            ->properties(Schema::integer('id'));
    }
}
