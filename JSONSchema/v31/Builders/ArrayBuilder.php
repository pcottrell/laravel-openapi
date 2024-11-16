<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Items;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\UniqueItems;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\SharedBuilder;

interface ArrayBuilder extends
    SharedBuilder,
    MaxContains,
    MinContains,
    UniqueItems,
    MaxItems,
    MinItems,
    Items
{
}
