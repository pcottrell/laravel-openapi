<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

final class AllOf extends SchemaComposition
{
    public function compositionType(): string
    {
        return 'allOf';
    }
}
