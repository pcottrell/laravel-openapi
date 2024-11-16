<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NumeralBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Double;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\FloatNumber;

interface NumberBuilder extends
    NumeralBuilder,
    FloatNumber,
    Double
{
}
