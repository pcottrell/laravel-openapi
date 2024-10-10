<?php

namespace Tests\oooas\Doubles\Stubs;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ReusableSchemaStub extends ReusableSchemaFactory
{
    public function build(): Schema
    {
        return Schema::object('ReusableSchemaStub')
            ->properties(
                Schema::integer('id'),
                Schema::string('name'),
            );
    }
}
