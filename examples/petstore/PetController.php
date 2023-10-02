<?php

namespace Examples\Petstore;

use Examples\Petstore\OpenApi\Parameters\ListPetsParameters;
use Examples\Petstore\OpenApi\Responses\ErrorValidationResponse;
use Examples\Petstore\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Examples\Petstore\OpenApi\SecuritySchemes\OAuth2PasswordGrantSecurityScheme;
use Examples\Petstore\OpenApi\Tags\AnotherPetTag;
use Examples\Petstore\OpenApi\Tags\PetTag;
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
    #[OpenApi\Parameters(ListPetsParameters::class)]
    #[OpenApi\Response(ErrorValidationResponse::class, 422)]
    public function index()
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
    #[OpenApi\Parameters(ListPetsParameters::class)]
    #[OpenApi\Response(ErrorValidationResponse::class, 422)]
    public function multiPetTag()
    {
    }

    #[OpenApi\Operation(
        id: 'multiAuthSecurityFirstTest',
        tags: [PetTag::class],
        security: [OAuth2PasswordGrantSecurityScheme::class, BearerTokenSecurityScheme::class],
        summary: 'List all pets.',
        description: 'List all pets from the database.',
    )]
    #[OpenApi\Parameters(ListPetsParameters::class)]
    public function multiAuthSecurityFirstTest()
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
    public function multiAuthSecuritySecondTest()
    {
    }
}
