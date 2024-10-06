<?php

namespace Tests\Doubles\Fakes\Petstore\Schemas;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SchemaContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class PetSchema extends ReusableSchemaFactory
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
