<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

class AllOf extends SchemaComposition
{
    protected function compositionType(): string
    {
        return 'allOf';
    }
}
