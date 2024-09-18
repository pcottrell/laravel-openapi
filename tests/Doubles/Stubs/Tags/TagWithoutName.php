<?php

namespace Tests\Doubles\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

class TagWithoutName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->description('Post Tag');
    }
}
