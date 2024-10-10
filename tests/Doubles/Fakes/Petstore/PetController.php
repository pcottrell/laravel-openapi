<?php

namespace Tests\Doubles\Fakes\Petstore;

use MohammadAlavi\LaravelOpenApi\Attributes as OpenApi;
use Tests\Doubles\Fakes\Petstore\Parameters\ListPetsParameters;
use Tests\Doubles\Fakes\Petstore\Responses\ErrorValidationResponse;
use Tests\Doubles\Fakes\Petstore\Responses\ReusableComponentErrorValidationResponse;
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
    #[OpenApi\Parameters(ListPetsParameters::class)]
    #[OpenApi\Response(ReusableComponentErrorValidationResponse::class)]
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
    #[OpenApi\Parameters(ListPetsParameters::class)]
    #[OpenApi\Response(ErrorValidationResponse::class)]
    public function multiPetTag(): void
    {
    }

    #[OpenApi\Operation(
        id: 'nestedSecurityFirstTest',
        tags: [PetTag::class],
        security: [OAuth2PasswordGrantSecurityScheme::class, BearerTokenSecurityScheme::class],
        summary: 'List all pets.',
        description: 'List all pets from the database.',
    )]
    #[OpenApi\Parameters(ListPetsParameters::class)]
    public function nestedSecurityFirst(): void
    {
    }

    #[OpenApi\Operation(
        id: 'nestedSecuritySecondTest',
        tags: AnotherPetTag::class,
        security: [
            BearerTokenSecurityScheme::class,
            [
                OAuth2PasswordGrantSecurityScheme::class,
                BearerTokenSecurityScheme::class,
            ],
        ],
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: null,
    )]
    public function nestedSecuritySecond(): void
    {
    }
}
