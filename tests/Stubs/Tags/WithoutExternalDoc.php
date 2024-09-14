<?php

namespace Tests\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

class WithoutExternalDoc extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('PostWithoutExternalDoc')
            ->description('Post Tag');
    }
}
