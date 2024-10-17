<?php

namespace Tests\Doubles\Fakes\Petstore\Responses\Response;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ReusableComponentErrorValidationResponse extends ReusableResponseFactory
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
