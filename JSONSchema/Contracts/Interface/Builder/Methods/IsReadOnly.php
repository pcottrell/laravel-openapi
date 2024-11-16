<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface IsReadOnly
{
    public function readOnly(bool $value): static;
}
