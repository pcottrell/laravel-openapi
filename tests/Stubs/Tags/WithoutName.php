<?php

namespace Tests\Stubs\Tags;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

class WithoutName extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->description('Post Tag');
    }
}
