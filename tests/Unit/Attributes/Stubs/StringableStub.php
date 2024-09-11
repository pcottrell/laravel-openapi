<?php

namespace Tests\Unit\Attributes\Stubs;

class StringableStub implements \Stringable
{
    public function __toString(): string
    {
        return 'stringable';
    }
}
