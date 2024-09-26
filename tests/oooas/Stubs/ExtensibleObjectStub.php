<?php

namespace Tests\oooas\Stubs;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class ExtensibleObjectStub extends ExtensibleObject
{
    protected function toArray(): array
    {
        return Arr::filter([
            'objectId' => $this->objectId,
            'ref' => $this->ref,
        ]);
    }
}
