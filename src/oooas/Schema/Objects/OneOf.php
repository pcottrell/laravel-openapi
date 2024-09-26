<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

class OneOf extends SchemaComposition
{
    protected function compositionType(): string
    {
        return 'oneOf';
    }
}
