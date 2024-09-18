<?php

namespace Tests\Doubles\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

class TagNullName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name(null)
            ->description('Post Tag');
    }
}
