<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;

class BaseObjectFake extends BaseObject
{
    protected function toArray(): array
    {
        return [];
    }
}
