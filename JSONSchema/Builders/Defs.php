<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Def;

interface Defs
{
    public function defs(Def ...$def): static;
}
