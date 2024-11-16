<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface IsWriteOnly
{
    public function writeOnly(bool $value): static;
}
