<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface IsWriteOnly
{
    public function writeOnly(bool $value): static;
}
