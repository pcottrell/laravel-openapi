<?php

namespace Tests\oooas\Doubles\Fakes;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;

class ExtensibleObjectFake extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected function toArray(): array
    {
        return [];
    }
}
