<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;

class NonExtensibleObjectFake extends JsonSerializable
{
    protected function toArray(): array
    {
        return [];
    }
}
