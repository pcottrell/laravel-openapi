<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

class AnyOf extends SchemaComposition
{
    protected function compositionType(): string
    {
        return 'anyOf';
    }
}
