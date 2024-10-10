<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;

class AllOf extends SchemaComposition
{
    use SimpleCreatorTrait;

    protected function compositionType(): string
    {
        return 'allOf';
    }
}
