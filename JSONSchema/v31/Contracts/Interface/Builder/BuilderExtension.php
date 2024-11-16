<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Double;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\FloatNumber;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Int32;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\Extensions\Int64;

interface BuilderExtension extends
    Builder,
    Int32,
    Int64,
    FloatNumber,
    Double
{
}
