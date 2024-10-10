<?php

namespace Tests\Doubles\Fakes\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class DefaultResponse implements ResponseFactory
{
    public function build(): Response
    {
        return Response::internalServerError('Default response')
            ->content(
                MediaType::json()->schema(Schema::create('default_response_schema')),
            );
    }
}
