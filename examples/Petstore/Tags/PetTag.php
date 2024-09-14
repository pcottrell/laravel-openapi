<?php

namespace Examples\Petstore\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

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
