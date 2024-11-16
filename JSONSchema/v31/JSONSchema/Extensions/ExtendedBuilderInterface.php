<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Double;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\FloatNumber;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Int32;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Builders\Int64;

interface ExtendedBuilderInterface extends
    BuilderInterface,
    Int32,
    Int64,
    FloatNumber,
    Double
{
}
