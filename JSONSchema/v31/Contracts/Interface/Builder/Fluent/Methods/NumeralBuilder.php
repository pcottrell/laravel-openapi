<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods\SharedBuilder;

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
