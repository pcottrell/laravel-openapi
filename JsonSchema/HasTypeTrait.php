<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

trait HasTypeTrait
{
    private Type $type;

    public function is(string $type): bool
    {
        return $this->type->equals($type);
    }
}
