<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Examples
{
    public function examples(mixed ...$example): static;
}
