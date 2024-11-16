<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties\Property;

interface Properties
{
    public function properties(Property ...$property): static;
}
