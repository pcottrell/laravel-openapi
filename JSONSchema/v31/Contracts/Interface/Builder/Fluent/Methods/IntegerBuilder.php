<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Fluent\Methods\NumeralBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Int32;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Int64;

interface IntegerBuilder extends
    NumeralBuilder,
    Int32,
    Int64
{
}
