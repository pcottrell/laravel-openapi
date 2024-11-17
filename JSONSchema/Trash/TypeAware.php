<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash;

interface TypeAware
{
    public function is(string $type): bool;
}
