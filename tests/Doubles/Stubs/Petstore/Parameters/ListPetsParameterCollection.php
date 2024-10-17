<?php

namespace Tests\Doubles\Stubs\Petstore\Parameters;

use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\ParameterCollectionFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ListPetsParameterCollection implements ParameterCollectionFactory
{
    public function build(): ParameterCollection
    {
        return ParameterCollection::create(
            Parameter::query()
                ->name('limit')
                ->description('How many items to return at one time (max 100)')
                ->required(false)
                ->schema(
                    Schema::integer('integer_test')
                        ->format(Schema::FORMAT_INT32),
                ),
        );
    }
}
