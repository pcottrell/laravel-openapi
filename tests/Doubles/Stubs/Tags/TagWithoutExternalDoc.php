<?php

namespace Tests\Doubles\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

class TagWithoutExternalDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('PostWithoutExternalDoc')
            ->description('Post Tag');
    }
}
