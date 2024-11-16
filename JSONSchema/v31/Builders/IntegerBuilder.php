<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Int32;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Int64;

interface IntegerBuilder extends
    NumeralBuilder,
    Int32,
    Int64
{
}
