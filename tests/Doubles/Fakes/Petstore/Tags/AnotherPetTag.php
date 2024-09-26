<?php

namespace Tests\Doubles\Fakes\Petstore\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\ExternalDocs;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

class AnotherPetTag extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('AnotherPet')
            ->description('Everything about your other Pets!')
            ->externalDocs(
                ExternalDocs::create()
                    ->description('Find out more')
                    ->url('https://swagger.io'),
            );
    }
}
