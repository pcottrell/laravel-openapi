<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface;

interface TypeAware
{
    public function is(string $type): bool;
}
