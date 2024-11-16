<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocab;

interface Vocabulary
{
    public function vocabulary(Vocab ...$vocab): static;
}
