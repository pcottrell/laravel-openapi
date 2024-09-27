<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;

class NonExtensibleObjectFake extends BaseObject
{
    protected function toArray(): array
    {
        return [];
    }
}
