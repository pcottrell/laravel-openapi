<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;

class AllOf extends SchemaComposition
{
    use SimpleCreatorTrait;

    protected function compositionType(): string
    {
        return 'allOf';
    }
}
