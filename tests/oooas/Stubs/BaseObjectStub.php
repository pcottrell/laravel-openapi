<?php

namespace Tests\oooas\Stubs;

use MohammadAlavi\ObjectOrientedOAS\Objects\BaseObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class BaseObjectStub extends BaseObject
{
    public function generate(): array
    {
        return Arr::filter([
            'objectId' => $this->objectId,
            'ref' => $this->ref,
        ]);
    }
}
