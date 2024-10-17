<?php

namespace Tests\Doubles\Stubs\Petstore\Tags;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

class PetTag extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('Pet')
            ->description('Everything about your Pets')
            ->externalDocs(
                ExternalDocs::create()
                    ->description('Find out more')
                    ->url('https://swagger.io'),
            );
    }
}
