<?php

namespace Tests\Doubles\Fakes\Petstore\Parameters;

use MohammadAlavi\LaravelOpenApi\Collections\Parameters;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ParametersFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ListPetsParameters implements ParametersFactory
{
    public function build(): Parameters
    {
        return Parameters::create(
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
