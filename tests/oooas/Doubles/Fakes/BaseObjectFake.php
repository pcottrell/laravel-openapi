<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\BaseObject;

class BaseObjectFake extends BaseObject
{
    protected function toArray(): array
    {
        return [];
    }
}
