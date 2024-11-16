<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties\Property;

interface Properties
{
    public function properties(Property ...$property): static;
}
