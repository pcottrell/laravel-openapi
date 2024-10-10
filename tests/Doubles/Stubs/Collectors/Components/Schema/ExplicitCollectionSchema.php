<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

#[Collection('test')]
class ExplicitCollectionSchema extends ReusableSchemaFactory
{
    public function build(): Schema
    {
        return Schema::object('object_test')
            ->properties(Schema::integer('integer_test'));
    }
}
