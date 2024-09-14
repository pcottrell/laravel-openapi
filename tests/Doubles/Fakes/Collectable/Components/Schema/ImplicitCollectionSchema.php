<?php

namespace Tests\Doubles\Fakes\Collectable\Components\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ImplicitCollectionSchema extends SchemaFactory implements Reusable
{
    public function build(): Schema
    {
        return Schema::object();
    }
}
