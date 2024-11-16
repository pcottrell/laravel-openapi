<?php

namespace Tests\Doubles\Stubs\Petstore\Parameters;

use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\ParameterCollectionFactory;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Formats\IntegerFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Review\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;

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
                    Schema::integer()
                        ->format(IntegerFormat::INT32),
                ),
        );
    }
}
