<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\BaseObject;

class NonExtensibleObjectFake extends BaseObject
{
    protected function toArray(): array
    {
        return [];
    }
}
