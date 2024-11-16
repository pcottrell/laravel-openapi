<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface UniqueItems
{
    public function uniqueItems(bool $value = true): static;
}
