<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

class NonExtensibleObjectFake extends Generatable
{
    protected function toArray(): array
    {
        return [];
    }
}
