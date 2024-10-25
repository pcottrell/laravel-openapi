<?php

namespace Tests\Doubles\Stubs\Petstore\Schemas;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\JsonSchema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class PetSchema extends ReusableSchemaFactory
{
    public function build(): JsonSchema
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
