<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties\Property;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\JSONSchema;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Schema;

#[Collection('test')]
class ExplicitCollectionSchema extends ReusableSchemaFactory
{
    public function build(): JSONSchema
    {
        return Schema::object()
            ->properties(
                Property::create('id', Schema::integer()),
            );
    }
}
