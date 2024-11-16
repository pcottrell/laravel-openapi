<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods\NumeralBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Double;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\FloatNumber;

interface NumberBuilder extends
    NumeralBuilder,
    FloatNumber,
    Double
{
}
