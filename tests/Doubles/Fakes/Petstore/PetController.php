<?php

namespace Tests\Doubles\Fakes\Petstore;

use MohammadAlavi\LaravelOpenApi\Attributes as OpenApi;
use Tests\Doubles\Fakes\Petstore\Parameters\ListPetsParameter;
use Tests\Doubles\Fakes\Petstore\Responses\ErrorValidationResponse;
use Tests\Doubles\Fakes\Petstore\SecuritySchemes\BearerTokenSecurityScheme;
use Tests\Doubles\Fakes\Petstore\SecuritySchemes\OAuth2PasswordGrantSecurityScheme;
use Tests\Doubles\Fakes\Petstore\Tags\AnotherPetTag;
use Tests\Doubles\Fakes\Petstore\Tags\PetTag;

#[OpenApi\PathItem]
class PetController
{
    #[OpenApi\Operation(
        id: 'listPets',
        tags: PetTag::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: true,
    )]
    #[OpenApi\Parameter(ListPetsParameter::class)]
    #[OpenApi\Response(ErrorValidationResponse::class, 422)]
    public function index(): void
    {
    }

    #[OpenApi\Operation(
        id: 'multiPetTag',
        tags: [PetTag::class, AnotherPetTag::class],
        security: BearerTokenSecurityScheme::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: false,
    )]
    #[OpenApi\Parameter(ListPetsParameter::class)]
    #[OpenApi\Response(ErrorValidationResponse::class, 422)]
    public function multiPetTag(): void
    {
    }

    #[OpenApi\Operation(
        id: 'multiAuthSecurityFirstTest',
        tags: [PetTag::class],
        security: [OAuth2PasswordGrantSecurityScheme::class, BearerTokenSecurityScheme::class],
        summary: 'List all pets.',
        description: 'List all pets from the database.',
    )]
    #[OpenApi\Parameter(ListPetsParameter::class)]
    public function multiAuthSecurityFirst(): void
    {
    }

    #[OpenApi\Operation(
        id: 'multiAuthSecuritySecondTest',
        tags: AnotherPetTag::class,
        security: [BearerTokenSecurityScheme::class, [OAuth2PasswordGrantSecurityScheme::class, BearerTokenSecurityScheme::class]],
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: null,
    )]
    public function multiAuthSecuritySecond(): void
    {
    }
}
