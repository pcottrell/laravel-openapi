<?php

namespace Tests\oooas\Doubles\Stubs;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties\Property;
use MohammadAlavi\ObjectOrientedJSONSchema\Schema;

class ReusableSchemaStub extends ReusableSchemaFactory
{
    public function build(): Descriptor
    {
        return Schema::object()
            ->properties(
                Property::create('id', Schema::integer()),
                Property::create('name', Schema::string()),
            );
    }
}
