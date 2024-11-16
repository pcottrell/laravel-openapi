<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocab;

interface Vocabulary
{
    public function vocabulary(Vocab ...$vocab): static;
}
