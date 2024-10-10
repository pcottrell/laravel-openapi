<?php

namespace Tests\Doubles\Stubs\Collectors\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class ImplicitCollectionSchema extends ReusableSchemaFactory
{
    public function build(): Schema
    {
        return Schema::object('object_test')
            ->properties(Schema::integer('integer_test'));
    }
}
