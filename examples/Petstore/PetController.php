<?php

namespace Examples\Petstore;

use Examples\Petstore\Parameters\ListPetsParameter;
use Examples\Petstore\Responses\ErrorValidationResponse;
use Examples\Petstore\SecuritySchemes\BearerTokenSecurityScheme;
use Examples\Petstore\SecuritySchemes\OAuth2PasswordGrantSecurityScheme;
use Examples\Petstore\Tags\AnotherPetTag;
use Examples\Petstore\Tags\PetTag;
use MohammadAlavi\LaravelOpenApi\Attributes as OpenApi;

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
