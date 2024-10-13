<?php

namespace Tests\Doubles\Fakes\Petstore;

use MohammadAlavi\LaravelOpenApi\Attributes as OpenAPI;
use Tests\Doubles\Fakes\Petstore\Parameters\ListPetsParameterCollection;
use Tests\Doubles\Fakes\Petstore\Responses\MixedMultiResponses;
use Tests\Doubles\Fakes\Petstore\Responses\SingleResponses;
use Tests\Doubles\Fakes\Petstore\Responses\SingleReusableResponses;
use Tests\Doubles\Fakes\Petstore\Security\ExampleComplexMultiSecurityRequirementSecurity;
use Tests\Doubles\Fakes\Petstore\Security\ExampleSimpleMultiSecurityRequirementSecurity;
use Tests\Doubles\Fakes\Petstore\Security\ExampleSingleSecurityRequirementSecurity;
use Tests\Doubles\Fakes\Petstore\Tags\AnotherPetTag;
use Tests\Doubles\Fakes\Petstore\Tags\PetTag;

#[OpenAPI\PathItem]
class PetController
{
    #[OpenAPI\Operation(
        id: 'listPets',
        tags: PetTag::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: true,
    )]
    #[OpenAPI\Parameters(ListPetsParameterCollection::class)]
    #[OpenAPI\Responses(SingleReusableResponses::class)]
    public function index(): void
    {
    }

    #[OpenAPI\Operation(
        id: 'multiPetTag',
        tags: [PetTag::class, AnotherPetTag::class],
        security: ExampleSingleSecurityRequirementSecurity::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
        deprecated: false,
    )]
    #[OpenAPI\Parameters(ListPetsParameterCollection::class)]
    #[OpenAPI\Responses(MixedMultiResponses::class)]
    public function multiPetTag(): void
    {
    }

    #[OpenAPI\Operation(
        id: 'nestedSecurityFirstTest',
        tags: [PetTag::class],
        security: ExampleSimpleMultiSecurityRequirementSecurity::class,
        summary: 'List all pets.',
        description: 'List all pets from the database.',
    )]
    #[OpenAPI\Parameters(ListPetsParameterCollection::class)]
    #[OpenAPI\Responses(SingleResponses::class)]
    public function nestedSecurityFirst(): void
    {
    }

    #[OpenAPI\Operation(
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
