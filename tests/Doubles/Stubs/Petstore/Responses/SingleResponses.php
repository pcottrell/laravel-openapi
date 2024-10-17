<?php

namespace Tests\Doubles\Stubs\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ResponsesFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Responses;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

final class SingleResponses extends ResponsesFactory
{
    public function build(): Responses
    {
        return Responses::create(
            Response::unprocessableEntity()
            ->content(
                MediaType::json()->schema(Schema::object('object_test')->properties(
                    Schema::string('message')->example('The given data was invalid.'),
                    Schema::object('errors')
                        ->additionalProperties(
                            Schema::array('array_test')->items(Schema::string('string_test')),
                        )
                        ->example(['field' => ['Something is wrong with this field!']]),
                )),
            ),
        );
    }
}
