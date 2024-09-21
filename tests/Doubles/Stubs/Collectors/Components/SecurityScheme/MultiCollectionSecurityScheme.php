<?php

namespace Tests\Doubles\Stubs\Collectors\Components\SecurityScheme;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

#[Collection(['test', Generator::COLLECTION_DEFAULT])]
class MultiCollectionSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('test collection SecurityScheme');
    }
}
