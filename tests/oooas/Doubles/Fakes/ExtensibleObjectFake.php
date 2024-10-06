<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;

class ExtensibleObjectFake extends ExtensibleObject
{
    protected function toArray(): array
    {
        return [];
    }
}
