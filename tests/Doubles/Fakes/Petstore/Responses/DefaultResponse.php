<?php

namespace Tests\Doubles\Fakes\Petstore\Responses;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class DefaultResponse implements ResponseFactory
{
    public function build(): Response
    {
        return Response::internalServerError('Default response')
            ->content(
                MediaType::json()->schema(Schema::create()),
            );
    }
}
