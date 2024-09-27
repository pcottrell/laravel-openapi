<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class BaseObjectFake extends BaseObject
{
    protected function toArray(): array
    {
        return Arr::filter([
            'objectId' => $this->objectId,
            'ref' => $this->ref,
        ]);
    }
}
