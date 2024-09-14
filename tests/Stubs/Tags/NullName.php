<?php

namespace Tests\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

class NullName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name(null)
            ->description('Post Tag');
    }
}
