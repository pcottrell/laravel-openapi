<?php

namespace Tests\Doubles\Fakes\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ErrorValidationResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $schema = Schema::object()->properties(
            Schema::string('message')->example('The given data was invalid.'),
            Schema::object('errors')
                ->additionalProperties(
                    Schema::array()->items(Schema::string()),
                )
                ->example(['field' => ['Something is wrong with this field!']]),
        );

        return Response::create('ErrorValidation')
            ->description('Validation errors')
            ->content(
                MediaType::json()->schema($schema),
            );
    }
}
