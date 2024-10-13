<?php

namespace Tests\Doubles\Fakes\Petstore;

use MohammadAlavi\LaravelOpenApi\Attributes as OpenApi;
use Tests\Doubles\Fakes\Petstore\Parameters\ListPetsParameterCollection;
use Tests\Doubles\Fakes\Petstore\Responses\ErrorValidationResponse;
use Tests\Doubles\Fakes\Petstore\Responses\ReusableComponentErrorValidationResponse;
use Tests\Doubles\Fakes\Petstore\Security\ExampleComplexMultiSecurityRequirementSecurity;
use Tests\Doubles\Fakes\Petstore\Security\ExampleSimpleMultiSecurityRequirementSecurity;
use Tests\Doubles\Fakes\Petstore\Security\ExampleSingleSecurityRequirementSecurity;
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
    #[OpenApi\Parameters(ListPetsParameterCollection::class)]
    #[OpenApi\Response(ReusableComponentErrorValidationResponse::class)]
    public function index(): void
    {
    }

    #[OpenApi\Operation(
        id: 'multiPetTag',
        tags: [PetTag::class, AnotherPetTag::class],
        security: ExampleSingleSecurityRequirementSecurity::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: false,
    )]
    #[OpenApi\Parameters(ListPetsParameterCollection::class)]
    #[OpenApi\Response(ErrorValidationResponse::class)]
    public function multiPetTag(): void
    {
    }

    #[OpenApi\Operation(
        id: 'nestedSecurityFirstTest',
        tags: [PetTag::class],
        security: ExampleSimpleMultiSecurityRequirementSecurity::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
    )]
    #[OpenApi\Parameters(ListPetsParameterCollection::class)]
    public function nestedSecurityFirst(): void
    {
    }

    #[OpenApi\Operation(
        id: 'nestedSecuritySecondTest',
        tags: AnotherPetTag::class,
        security: ExampleComplexMultiSecurityRequirementSecurity::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: null,
    )]
    public function nestedSecuritySecond(): void
    {
    }
}
