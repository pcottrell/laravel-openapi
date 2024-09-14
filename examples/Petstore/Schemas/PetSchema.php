<?php

namespace Examples\Petstore\Schemas;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class PetSchema extends SchemaFactory implements Reusable
{
    /**
     * @return Schema
     *
     * @throws InvalidArgumentException
     */
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
