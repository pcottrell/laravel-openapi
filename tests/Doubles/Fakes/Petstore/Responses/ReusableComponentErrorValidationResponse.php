<?php

namespace Tests\Doubles\Fakes\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class ReusableComponentErrorValidationResponse extends ReusableResponseFactory
{
    public function build(): Response
    {
        $schema = Schema::object()->properties(
            Schema::string()->example('The given data was invalid.'),
            Schema::object()
                ->additionalProperties(
                    Schema::array()->items(Schema::string()),
                )
                ->example(['field' => ['Something is wrong with this field!']]),
        );

        return Response::unprocessableEntity()
            ->content(
                MediaType::json()->schema($schema),
            );
    }
}
