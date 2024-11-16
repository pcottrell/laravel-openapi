<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Review;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type;

trait HasTypeTrait
{
    private Type $type;

    public function is(string $type): bool
    {
        return $this->type->equals($type);
    }
}
