<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;

class AnyOf extends SchemaComposition
{
    use SimpleCreatorTrait;

    protected function compositionType(): string
    {
        return 'anyOf';
    }
}
