<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Review;

interface TypeAware
{
    public function is(string $type): bool;
}
