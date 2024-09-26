<?php

namespace Tests\Doubles\Fakes\Petstore\Parameters;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class ListPetsParameter extends ParameterFactory
{
    /** @return Parameter[] */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('limit')
                ->description('How many items to return at one time (max 100)')
                ->required(false)
                ->schema(
                    Schema::integer()->format(Schema::FORMAT_INT32),
                ),
        ];
    }
}
