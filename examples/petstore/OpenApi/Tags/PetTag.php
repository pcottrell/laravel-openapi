<?php

namespace Examples\Petstore\OpenApi\Tags;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use Vyuldashev\LaravelOpenApi\Factories\TagFactory;

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
                    ->url('http://swagger.io')
            );
    }
}
