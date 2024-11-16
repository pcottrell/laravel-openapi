<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AdditionalProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DependentRequired;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Properties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Required;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\SharedBuilder;

interface ObjectBuilder extends
    SharedBuilder,
    AdditionalProperties,
    Properties,
    DependentRequired,
    MaxProperties,
    MinProperties,
    Required
{
}
