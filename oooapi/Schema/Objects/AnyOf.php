<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

final class AnyOf extends SchemaComposition
{
    public function compositionType(): string
    {
        return 'anyOf';
    }
}
