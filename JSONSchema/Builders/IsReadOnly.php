<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface IsReadOnly
{
    public function readOnly(bool $value): static;
}
