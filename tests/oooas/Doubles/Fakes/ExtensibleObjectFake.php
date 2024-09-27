<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class ExtensibleObjectFake extends ExtensibleObject
{
    protected function toArray(): array
    {
        return Arr::filter([
            'objectId' => $this->objectId,
            'ref' => $this->ref,
        ]);
    }
}
