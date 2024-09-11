<?php

namespace Examples\Petstore\OpenApi\Parameters;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ListPetsParameter extends ParameterFactory
{
    /**
     * @return Parameter[]
     */
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
