<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;

class OneOf extends SchemaComposition
{
    use SimpleCreatorTrait;

    protected function compositionType(): string
    {
        return 'oneOf';
    }
}
