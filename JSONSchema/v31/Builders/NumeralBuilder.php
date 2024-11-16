<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\SharedBuilder;

interface NumeralBuilder extends
    SharedBuilder,
    ExclusiveMaximum,
    ExclusiveMinimum,
    Maximum,
    Minimum,
    MultipleOf,
    Format
{
}
