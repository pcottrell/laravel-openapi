<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

final class OneOf extends SchemaComposition
{
    public function compositionType(): string
    {
        return 'oneOf';
    }
}
