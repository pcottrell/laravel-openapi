<?php

namespace Tests\Doubles\Stubs\Attributes;

class Stringable implements \Stringable
{
    public function __toString(): string
    {
        return 'stringable';
    }
}
