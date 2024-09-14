<?php

namespace Tests\Doubles\Stubs\Attributes;

class StringableStub implements \Stringable
{
    public function __toString(): string
    {
        return 'stringable';
    }
}
