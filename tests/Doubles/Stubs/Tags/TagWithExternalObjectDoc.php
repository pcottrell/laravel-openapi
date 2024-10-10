<?php

namespace Tests\Doubles\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

class TagWithExternalObjectDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('PostWithExternalObjectDoc')
            ->description('Post Tag')
            ->externalDocs(
                ExternalDocs::create()
                    ->description('External API documentation')
                    ->url('https://example.com/external-docs'),
            );
    }
}
