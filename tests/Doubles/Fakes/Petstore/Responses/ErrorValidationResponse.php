<?php

namespace Tests\Doubles\Fakes\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ErrorValidationResponse implements ResponseFactory
{
    public function build(): Response
    {
        $schema = Schema::object('object_test')->properties(
            Schema::string('message')->example('The given data was invalid.'),
            Schema::object('errors')
                ->additionalProperties(
                    Schema::array('array_test')->items(Schema::string('string_test')),
                )
                ->example(['field' => ['Something is wrong with this field!']]),
        );

        return Response::unprocessableEntity()
            ->content(
                MediaType::json()->schema($schema),
            );
    }
}
