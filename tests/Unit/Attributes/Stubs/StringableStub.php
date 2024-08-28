<?php

namespace Tests\Unit\Attributes\Stubs;

use Stringable;

class StringableStub implements Stringable
{
    public function __toString(): string
    {
        return 'stringable';
    }
}