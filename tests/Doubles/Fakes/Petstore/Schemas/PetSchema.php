<?php

namespace Tests\Doubles\Fakes\Petstore\Schemas;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;

class PetSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        return Schema::object('Pet')
            ->required('id', 'name')
            ->properties(
                Schema::integer('id')->format(Schema::FORMAT_INT64),
                Schema::string('name'),
                Schema::string('tag'),
            );
    }
}
