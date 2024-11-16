<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Def;

interface Defs
{
    public function defs(Def ...$def): static;
}
